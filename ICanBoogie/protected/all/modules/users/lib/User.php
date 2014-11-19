<?php

namespace BlogMVC\Modules\Users;

/**
 * @property-read bool $is_guest `true` if the user is a guest, `false` otherwise.
 * @property-read bool $is_authenticated `true` if the user is authenticated, `false` otherwise.
 */
class User extends \ICanBoogie\ActiveRecord
{
	const MODEL_ID = 'users';

	public $id;
	public $username;
	public $password;

	protected function get_is_guest()
	{
		return !$this->id;
	}

	protected function get_is_authenticated()
	{
		return $this->id && $this->app->session->user_id == $this->id;
	}

	public function __toString()
	{
		return $this->username;
	}

	public function verify_password($password)
	{
		return sha1($password) == $this->password;
	}

	public function login()
	{
		$this->app->session->user_id = $this->id;
	}

	public function logout()
	{
		$this->app->session->user_id = null;
	}

	public function has_permission($permission, $target=null)
	{
		return $this->is_authenticated;
	}

	public function has_ownership(\ICanBoogie\Module $module, \ICanBoogie\ActiveRecord $record)
	{
		return $record->user_id = $this->id;
	}
}
