<?php

namespace BlogMVC\Modules\Posts;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'patron.markups' => [

		'posts:latests' => [ $hooks . 'markup_posts_latests' ]

	]

];
