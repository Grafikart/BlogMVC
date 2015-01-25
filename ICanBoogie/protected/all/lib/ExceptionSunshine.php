<?php

namespace BlogMVC;

use ICanBoogie\GetterTrait;

class ExceptionSunshine
{
	use GetterTrait;

	const MAX_STRING_LEN = 16;

	private $exception;

	public function __construct(\Exception $exception)
	{
		$this->exception = $exception;
	}

	protected function get_constructor()
	{
		return get_class($this->exception);
	}

	protected function get_title()
	{
		return basename(strtr(get_class($this->exception), '\\', '/'));
	}

	protected function get_message()
	{
		return $this->exception->getMessage();
	}

	protected function get_code()
	{
		return $this->exception->getCode();
	}

	protected function get_http_code()
	{
		$code = $this->code;

		if ($code < 100 || $code > 505)
		{
			return 500;
		}

		return $code;
	}

	protected function get_file()
	{
		return $this->exception->getFile();
	}

	protected function get_line()
	{
		return $this->exception->getLine();
	}

	public function __toString()
	{
		try
		{
			$constructor = $this->constructor;
			$message = $this->get_message();

			$with_stack_trace = self::format_trace($this->exception->getTrace());

			$content = <<<EOT
<strong>$constructor with the following message:</strong>

$message

in <em>{$this->file}</em> at line {$this->line}

$with_stack_trace
EOT;
		}
		catch (\Exception $e)
		{
			$content = (string) $this->exception;
		}

		$content = strip_tags($content, '<q><em><strong>');

		return <<<EOT
<pre class="alert alert-danger alert-error alert-exception">
$content
</pre>
EOT;

	}

	/**
	 * Formats a stack trace into an HTML element.
	 *
	 * @param array $trace
	 *
	 * @return string
	 */
	static public function format_trace(array $trace)
	{
		$root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
		$count = count($trace);
		$count_max = strlen((string) $count);

		$rc = "<strong>Stack trace:</strong>\n";

		foreach ($trace as $i => $node)
		{
			$trace_file = null;
			$trace_line = 0;
			$trace_class = null;
			$trace_type = null;
			$trace_args = null;
			$trace_function = null;

			extract($node, EXTR_PREFIX_ALL, 'trace');

			if ($trace_file)
			{
				$trace_file = str_replace('\\', '/', $trace_file);
				$trace_file = str_replace($root, '', $trace_file);
			}

			$params = [];

			if ($trace_args)
			{
				foreach ($trace_args as $arg)
				{
					switch (gettype($arg))
					{
						case 'array': $arg = 'Array'; break;
						case 'object': $arg = get_class($arg); break;
						case 'resource': $arg = 'Resource of type ' . get_resource_type($arg); break;
						case 'null': $arg = 'null'; break;

						default:
						{
							if (strlen($arg) > self::MAX_STRING_LEN)
							{
								$arg = substr($arg, 0, self::MAX_STRING_LEN) . '...';
							}

							$arg = '\'' . $arg .'\'';
						}
							break;
					}

					$params[] = $arg;
				}
			}

			$rc .= sprintf
			(
				"\n%{$count_max}d. <em>%s%s</em>%s%s%s(%s)",

				$count - $i, $trace_file, $trace_file ? ":$trace_line " : "", $trace_class, $trace_type,
				$trace_function, \ICanBoogie\escape(implode(', ', $params))
			);
		}

		return $rc;
	}
}
