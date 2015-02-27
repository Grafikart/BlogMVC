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

	protected function action_signin()
	{
		$this->view->template = null;
		$this->view->content = new SignInForm;
	}

	protected function action_signout()
	{
		return Request::from('/api/users/sign-out')->post();
	}
}
