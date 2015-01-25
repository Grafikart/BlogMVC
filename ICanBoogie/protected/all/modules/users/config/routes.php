<?php

namespace BlogMVC\Modules\Users;

return [

	'users:signin' => [

		'pattern' => '/signin',
		'controller' => __NAMESPACE__ . '\UsersController#signin'

	],

	'users:signout' => [

		'pattern' => '/signout',
		'controller' => __NAMESPACE__ . '\UsersController#signout'

	]

];
