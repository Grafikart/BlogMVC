<?php

namespace BlogMVC\Modules\Posts;

return [

	'posts:index' => [

		'pattern' => '/',
		'controller' => __NAMESPACE__ . '\ListController'

	],

	'posts:category' => [

		'pattern' => '/category/:category',
		'controller' => __NAMESPACE__ . '\ListController'

	],

	'posts:by-user' => [

		'pattern' => '/author/<id:\d+>',
		'controller' => __NAMESPACE__ . '\ListController'

	],

	'posts:view' => [

		'pattern' => '/:slug',
		'controller' => __NAMESPACE__ . '\ViewController'

	],

	'admin:posts:index' => [

		'pattern' => '/admin/posts',
		'controller' => __NAMESPACE__ . '\AdminController'

	],

	'admin:posts:new' => [

		'pattern' => '/admin/posts/new',
		'controller' => __NAMESPACE__ . '\NewController'

	],

	'admin:posts:edit' => [

		'pattern' => '/admin/posts/<id:\d+>/edit',
		'controller' => __NAMESPACE__ . '\EditController'

	],

	'admin:posts:delete' => [

		'pattern' => '/admin/posts/<id:\d+>/delete',
		'controller' => __NAMESPACE__ . '\DeleteController'

	],

	'redirect:admin' => [

		'pattern' => '/admin',
		'location' => '/admin/posts'
	]
];
