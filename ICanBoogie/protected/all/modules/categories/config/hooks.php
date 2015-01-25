<?php

namespace BlogMVC\Modules\Categories;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'events' => [

		'BlogMVC\Modules\Posts\SaveOperation::process' => $hooks . 'on_posts_save',
		'BlogMVC\Modules\Posts\DeleteOperation::process' => $hooks . 'on_posts_delete'

	],

	'patron.markups' => [

		'categories:home' => [ $hooks . 'markup_category_home' ]

	]

];
