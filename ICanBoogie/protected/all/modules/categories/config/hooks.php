<?php

namespace BlogMVC\Modules\Categories;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'patron.markups' => [

		'categories:home' => [ $hooks . 'markup_category_home' ]

	]

];
