<?php

namespace BlogMVC\Modules\Users;

use ICanBoogie\Errors;

class SignInOperation extends \ICanBoogie\Operation
{
	protected function get_controls()
	{
		return [

			self::CONTROL_FORM => true

		] + parent::get_controls();
	}

	protected function lazy_get_form()
	{
		return new SignInForm;
	}

	protected function validate(Errors $errors)
	{
		$request = $this->request;
		$username = $request['username'];
		$password = $request['password'];

		$user = $this->module->model
		->filter_by_username($username)
		->one;

		if (!$user || !$user->verify_password($password))
		{
			$errors['username'] = $errors->format("Unknown username/password combinaison");
			$errors['password'] = true;

			return false;
		}

		$this->user = $this->module->model[$user->id];

		return true;
	}

	protected function process()
	{
		$this->user->login();

		$this->response->location = $this->request->uri;

		return true;
	}
}
