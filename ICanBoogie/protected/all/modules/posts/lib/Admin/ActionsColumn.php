<?php

namespace BlogMVC\Modules\Posts\Admin;

use Brickrouge\ListViewColumn;
use Brickrouge\A;

class ActionsColumn extends ListViewColumn
{
	public function render_cell($row)
	{
		$routes = \ICanBoogie\app()->routes;

		$edit_link = new A("Edit", $routes['admin:posts:edit']->format($row), [

			'class' => 'btn btn-primary'

		]);

		$delete_link = new A("Delete", $routes['admin:posts:delete']->format($row), [

			'class' => 'btn btn-danger'

		]);

		return $edit_link . ' ' . $delete_link;
	}
}
