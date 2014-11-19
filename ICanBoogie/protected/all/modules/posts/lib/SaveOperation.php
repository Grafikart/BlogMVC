<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\DateTime;

class SaveOperation extends \ICanBoogie\SaveOperation
{
	protected function lazy_get_form()
	{
		return new EditForm;
	}

	protected function lazy_get_properties()
	{
		$properties = parent::lazy_get_properties();

		unset($properties['user_id']);

		if (!$this->key)
		{
			$properties['user_id'] = $this->app->user->id;
			$properties['created'] = DateTime::now();
		}

		return $properties;
	}

	protected function process()
	{
		$rc = parent::process();

		$this->response->message = $this->format($rc['mode'] == 'update' ? '%name has been updated.' : '%name has been created.', [

			'name' => $this->record->name

		]);

		$this->response->location = $this->app->routes['admin:posts:index'];

		return $rc;
	}
}
