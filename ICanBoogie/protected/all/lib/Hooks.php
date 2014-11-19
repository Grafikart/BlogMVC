<?php

namespace BlogMVC;

use ICanBoogie\ActiveRecord;
use ICanBoogie\DateTime;

class Hooks
{
	/*
	 * Events
	 */

	static public function on_routing_dispatcher_dispatch(\ICanBoogie\Routing\Dispatcher\DispatchEvent $event)
	{
		if (!$event->response || !$event->response->body)
		{
			return;
		}

		$event->response->body = new PageDecorator($event->response->body) . self::render_stats();
	}

	static public function on_exception_rescue(\ICanBoogie\Exception\RescueEvent $event)
	{
		$event->chain(function(\ICanBoogie\Exception\RescueEvent $event) {

			if (!$event->response || !$event->response->body)
			{
				return;
			}

			$event->response->body = new PageDecorator($event->response->body);

		});
	}

	static public function on_posts_save(\ICanBoogie\Operation\ProcessEvent $event, \BlogMVC\Modules\Posts\SaveOperation $target)
	{
		self::revoke_cached_sidebar();
	}

	static public function on_posts_delete(\ICanBoogie\Operation\ProcessEvent $event, \BlogMVC\Modules\Posts\DeleteOperation $target)
	{
		self::revoke_cached_sidebar();
	}

	static private function revoke_cached_sidebar()
	{
		unset(\ICanBoogie\app()->vars['cached_sidebar']);
	}

	/*
	 * Prototypes
	 */

	static public function url(ActiveRecord $record, $type='view')
	{
		return \ICanBoogie\app()->routes[$record->model_id . ':' . $type]->format($record);
	}

	static public function get_url(ActiveRecord $record)
	{
		return $record->url();
	}

	/*
	 * Markups
	 */

	static public function markup_time_ago(array $args, $engine, $template)
	{
		static $properties = [

			'y' => "year",
			'm' => "month",
			'd' => "day",
			'h' => "hour",
			'i' => "minute",
			's' => "second"

		];

		$datetime = $args['select'];

		if (!$datetime)
		{
			return;
		}

		$diff = DateTime::now()->diff($datetime);

		foreach ($properties as $property => $name)
		{
			$value = $diff->$property;

			if (!$value)
			{
				continue;
			}

			if ($property == 's' && $value < 60)
			{
				$str = "Just now";
			}
			else
			{
				$str = $value == 1 ? "one $name ago" : "$value " . \ICanBoogie\pluralize($name) . " ago";
			}

			return $template ? $engine($template, $str) : $str;
		}
	}

	static public function markup_cache_sidebar(array $args, $engine, $template)
	{
		$app = \ICanBoogie\app();
		$sidebar = $app->vars['cached_sidebar'];

		if (!$sidebar)
		{
			$app->vars['cached_sidebar'] = $sidebar = $engine($template);
		}

		return $sidebar;
	}

	/*
	 *
	 */
	static private function render_stats()
	{
		$boot_time = round((microtime(true) - $_SERVER['ICANBOOGIE_READY_TIME_FLOAT']) * 1000, 3);
		$total_time = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 3);

		return "<!-- booted in: $boot_time, completed in $total_time ms -->";
	}
}
