<?php

namespace BlogMVC;

use ICanBoogie\ActiveRecord;
use ICanBoogie\DateTime;
use ICanBoogie\Debug;
use ICanBoogie\Exception\RescueEvent as RescueExceptionEvent;
use ICanBoogie\HTTP\Response;
use ICanBoogie\Operation;
use ICanBoogie\Routing;
use ICanBoogie\View\View;

use Brickrouge\Alert;

class Hooks
{
	/*
	 * Events
	 */

	static public function on_routing_dispatcher_dispatch(Routing\Dispatcher\DispatchEvent $event)
	{
		if (!$event->response || !$event->response->body)
		{
			return;
		}

		$event->response->body = $event->response->body . self::render_stats();
	}

	static public function on_exception_rescue(RescueExceptionEvent $event)
	{
		$event->chain(function(RescueExceptionEvent $event, $target) {

			if ($event->response)
			{
				return;
			}

			try
			{
				$sunshine = new ExceptionSunshine($target);
			    $html = \ICanBoogie\app()->render($sunshine, [

				    'layout' => '@exception',

			    ]);

				$event->response = new Response($html, $sunshine->http_code, [

					'X-Exception-Origin' => $sunshine->file

				]);
			}
			catch (\Exception $e) { }

		});
	}

	static public function before_view_render(View\BeforeRender $event, View $target)
	{
		$target['user'] = $target->controller->user;
		$target['in_admin'] = strpos($target->controller->route->id, 'admin:') === 0;
		$target['alerts'] = [

			'success' => new Alert(Debug::fetch_messages(\ICanBoogie\LogLevel::SUCCESS), [

				Alert::CONTEXT => Alert::CONTEXT_SUCCESS

			]),

			'info' => new Alert(Debug::fetch_messages(\ICanBoogie\LogLevel::INFO), [

				Alert::CONTEXT => Alert::CONTEXT_INFO

			]),

			'error' => new Alert(Debug::fetch_messages(\ICanBoogie\LogLevel::ERROR), [

				Alert::CONTEXT => 'danger'

			]),

			'debug' => new Alert(Debug::fetch_messages(\ICanBoogie\LogLevel::DEBUG), [


			])

		];
	}

	static public function on_posts_save(Operation\ProcessEvent $event, Modules\Posts\SaveOperation $target)
	{
		self::revoke_cached_sidebar();
	}

	static public function on_posts_delete(Operation\ProcessEvent $event, Modules\Posts\DeleteOperation $target)
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
			return null;
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
		$boot_time = round(($_SERVER['ICANBOOGIE_READY_TIME_FLOAT'] - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 3);
		$total_time = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 3);

		return "<!-- booted in: $boot_time ms, completed in $total_time ms -->";
	}
}
