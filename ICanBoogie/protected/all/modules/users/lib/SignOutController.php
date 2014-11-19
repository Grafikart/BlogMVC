<?php

namespace BlogMVC\Modules\Users;

use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\Controller;

class SignOutController extends Controller
{
	public function __invoke(Request $request)
	{
		$signout_request = Request::from('/api/users/sign-out');

		return $signout_request();
	}
}
