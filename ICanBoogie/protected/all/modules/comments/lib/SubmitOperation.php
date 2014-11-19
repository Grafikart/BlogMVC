<?php

namespace BlogMVC\Modules\Comments;

use ICanBoogie\Errors;
use ICanBoogie\DateTime;
use ICanBoogie\HTTP\Request;

class SubmitOperation extends \ICanBoogie\SaveOperation
{
	protected function get_controls()
	{
		return [

			self::CONTROL_PERMISSION => false,
			self::CONTROL_RECORD => false,
			self::CONTROL_OWNERSHIP => false

		] + parent::get_controls();
	}

	protected function lazy_get_form()
	{
		return new SubmitForm;
	}

	protected function lazy_get_properties()
	{
		$properties = parent::lazy_get_properties();

		if (!$this->key)
		{
			$properties['created'] = DateTime::now();
		}

		return $properties;
	}

	protected function validate(Errors $errors)
	{
		$post_id = $this->request['post_id'];

		if (!$post_id)
		{
			$errors['post_id'] = $errors->format("PostID is required.");
		}
		else
		{
			$post = $this->app->models['posts'][$post_id];
		}

		return $errors;
	}

	protected function process()
	{
		$rc = parent::process();

		$this->response->message = $this->format("Your comment has been saved");

		return $rc;
	}
}
