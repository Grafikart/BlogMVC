<?php

namespace BlogMVC\Modules\Posts;

return [

	'posts:index' => [

		'pattern' => '/',
		'controller' => __NAMESPACE__ . '\PostsController#index'

	],

	'posts:category' => [

		'pattern' => '/category/:category',
		'controller' => __NAMESPACE__ . '\PostsController#index'

	],

	'posts:by-user' => [

		'pattern' => '/author/<id:\d+>',
		'controller' => __NAMESPACE__ . '\PostsController#index'

	],

	'posts:view' => [

		'pattern' => '/:slug',
		'controller' => __NAMESPACE__ . '\PostsController#show'

	],

	'admin:posts:index' => [

		'pattern' => '/admin/posts',
		'controller' => __NAMESPACE__ . '\PostsController#admin',
		'layout' => 'admin'

	],

	'admin:posts:new' => [

		'pattern' => '/admin/posts/new',
		'controller' => __NAMESPACE__ . '\PostsController#new',
		'template' => 'edit'

	],

	'admin:posts:edit' => [

		'pattern' => '/admin/posts/<id:\d+>/edit',
		'controller' => __NAMESPACE__ . '\PostsController#edit'

	],

	'admin:posts:delete' => [

		'pattern' => '/admin/posts/<id:\d+>/delete',
		'controller' => __NAMESPACE__ . '\PostsController#delete'

	],

	'redirect:admin' => [

		'pattern' => '/admin',
		'location' => '/admin/posts'
	]
];
