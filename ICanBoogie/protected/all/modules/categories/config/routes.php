<?php

namespace BlogMVC\Modules\Categories;

return [

	'categories:view' => [

		'pattern' => '/category/:slug',
		'controller' => 'BlogMVC\Modules\Posts\ListController'

	]

];
