<?php

namespace BlogMVC\Modules\Posts;

/**
 * Delete a post.
 *
 * @property Post $record
 */
class DeleteOperation extends \ICanBoogie\DeleteOperation
{
	protected function process()
	{
		$rc = parent::process();

		$this->response->message = $this->format("%name was deleted.", [ 'name' => $this->record->name ]);

		if (!$this->response->location)
		{
			$this->response->location = $this->app->routes['admin:posts:index'];
		}

		return $rc;
	}
}
