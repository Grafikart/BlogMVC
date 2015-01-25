<?php

namespace BlogMVC\Modules\Categories;

return [

	'categories:view' => [

		'pattern' => '/category/:slug',
		'controller' => __NAMESPACE__ . '\CategoriesController#show'

	]

];
