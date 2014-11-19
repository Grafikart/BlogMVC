<?php

namespace BlogMVC\Modules\Users;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'prototypes' => [

		'ICanBoogie\Core::get_user' => $hooks . 'core_get_user',
		'ICanBoogie\HTTP\Request\Context::get_user' => $hooks . 'request_context_get_user'

	],

	'events' => [

		'ICanBoogie\Routing\Dispatcher::dispatch:before' => $hooks . 'on_routing_dispatcher_dispatch',
		'ICanBoogie\AuthenticationRequired::rescue' => $hooks . 'on_authentication_required_rescue'

	]

];
