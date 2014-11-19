<?php

namespace BlogMVC;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'events' => [

		'ICanBoogie\Routing\Dispatcher::dispatch' => $hooks . 'on_routing_dispatcher_dispatch',
		'BlogMVC\Modules\Posts\SaveOperation::process' => $hooks . 'on_posts_save',
		'BlogMVC\Modules\Posts\DeleteOperation::process' => $hooks . 'on_posts_delete',
		'Exception::rescue' => $hooks . 'on_exception_rescue'

	],

	'prototypes' => [

		'BlogMVC\Modules\Categories\Category::url' => $hooks . 'url',
		'BlogMVC\Modules\Categories\Category::get_url' => $hooks . 'get_url',
		'BlogMVC\Modules\Posts\Post::url' => $hooks . 'url',
		'BlogMVC\Modules\Posts\Post::get_url' => $hooks . 'get_url',
		'BlogMVC\Modules\Users\User::url' => $hooks . 'url',
		'BlogMVC\Modules\Users\User::get_url' => $hooks . 'get_url'

	],

	'patron.markups' => [

		'time:ago' => [

			$hooks . 'markup_time_ago', [

				'select' => [ 'expression' => true, 'default' => 'this' ]

			]
		],

		'cache:sidebar' => [

			$hooks . 'markup_cache_sidebar'

		]
	]
];
