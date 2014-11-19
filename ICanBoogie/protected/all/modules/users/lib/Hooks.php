<?php

namespace BlogMVC\Modules\Users;

use ICanBoogie\ActiveRecord\RecordNotFound;
use ICanBoogie\AuthenticationRequired;
use ICanBoogie\HTTP\Response;

class Hooks
{
	/*
	 * Events
	 */
	static public function on_routing_dispatcher_dispatch(\ICanBoogie\Routing\Dispatcher\BeforeDispatchEvent $event, \ICanBoogie\Routing\Dispatcher $target)
	{
		if (strpos($event->route->id, 'admin:') !== 0)
		{
			return;
		}

		$user = $event->request->context->user;

		if (!$user->is_guest)
		{
			return;
		}

		throw new AuthenticationRequired;
	}

	static public function on_authentication_required_rescue(\ICanBoogie\Exception\RescueEvent $event, \ICanBoogie\AuthenticationRequired $target)
	{
		$event->response = new Response(new SignInForm, $target->getCode());
	}

	/*
	 * Prototypes
	 */

	static public function core_get_user(\ICanBoogie\Core $core)
	{
		return $core->request->context->user;
	}

	static public function request_context_get_user(\ICanBoogie\HTTP\Request\Context $context)
	{
		$app = \ICanBoogie\app();
		$user_id = $app->session->user_id;

		if ($user_id)
		{
			try
			{
				return $app->models['users'][$user_id];
			}
			catch (RecordNotFound $e)
			{
				$app->session->user_id = null;
			}
		}

		return new User;
	}
}
