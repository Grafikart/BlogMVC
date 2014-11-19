<?php

namespace BlogMVC;

use ICanBoogie\GetterTrait;

use Brickrouge\Decorator;

use BlogMVC\Controller\RenderTrait;
use Brickrouge\Alert;

class PageDecorator extends Decorator
{
	use GetterTrait;
	use RenderTrait;

	private $data;

	public function __construct($component)
	{
		parent::__construct($component);
	}

	protected function get_template_pathname()
	{
		if (strpos(\ICanBoogie\app()->request->route->id, 'admin:') === 0)
		{
			return __DIR__ . '/../templates/admin.html';
		}

		return __DIR__ . '/../templates/page.html';
	}

	protected function get_template_variables()
	{
		$app = \ICanBoogie\app();

		return [

			'component' => $this->component,

			'user' => $app->user,

			'in_admin' => strpos($app->request->route->id, 'admin:') === 0,

			'alerts' => [

				'success' => new Alert(\IcanBoogie\Debug::fetch_messages(\ICanBoogie\LogLevel::SUCCESS), [

					Alert::CONTEXT => Alert::CONTEXT_SUCCESS

				]),

				'info' => new Alert(\IcanBoogie\Debug::fetch_messages(\ICanBoogie\LogLevel::INFO), [

					Alert::CONTEXT => Alert::CONTEXT_INFO

				]),

				'error' => new Alert(\IcanBoogie\Debug::fetch_messages(\ICanBoogie\LogLevel::ERROR), [

					Alert::CONTEXT => 'danger'

				]),

				'debug' => new Alert(\IcanBoogie\Debug::fetch_messages(\ICanBoogie\LogLevel::DEBUG), [


				])

			]

		];
	}
}
