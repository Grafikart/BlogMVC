<?php

namespace BlogMVC\Modules\Comments;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'patron.markups' => [

		'comments:submit' => [ $hooks . 'markup_comments_submit', [

			'post' => [ 'expression' => true, 'default' => 'this' ]

		] ]

	]

];
