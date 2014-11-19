<?php

namespace BlogMVC\Modules\Comments;

use ICanBoogie\GetterTrait;

class CommentAuthor
{
	static private $instances = [];

	static public function from($username)
	{
		if (empty(self::$instances[$username]))
		{
			self::$instances[$username] = new static($username);
		}

		return self::$instances[$username];
	}

	use GetterTrait;

	private $username;

	protected function __construct($username)
	{
		$this->username = $username;
	}

	public function __toString()
	{
		return $this->username;
	}

	protected function get_name()
	{
		return $this->username;
	}

	protected function get_portrait()
	{
		preg_match('#\d+#', $this->username, $matches);

		list($id) = $matches + [ 0 => 9 ];

		return <<<EOT
<img src="http://lorempicsum.com/futurama/100/100/{$id}" width="100%">
EOT;
	}
}