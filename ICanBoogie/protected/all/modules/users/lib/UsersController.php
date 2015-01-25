<?php

namespace BlogMVC\Modules\Users;

use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\ActionController;

class UsersController extends ActionController
{
	protected function get_layout()
	{
		return 'admin';
	}

	public function get_signin()
	{
		$this->view->template = null;
		$this->view->content = new SignInForm;
	}

	public function any_signout()
	{
		return Request::from('/api/users/sign-out')->post();
	}
}
