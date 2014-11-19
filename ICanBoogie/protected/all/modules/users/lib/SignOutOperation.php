<?php

namespace BlogMVC\Modules\Users;

use ICanBoogie\Errors;

class SignOutOperation extends \ICanBoogie\Operation
{
	protected function validate(Errors $errors)
	{
		return true;
	}

	protected function process()
	{
		$this->app->user->logout();

		$this->response->location = '/';

		return true;
	}
}
