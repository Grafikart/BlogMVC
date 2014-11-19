<?php

namespace BlogMVC\Modules\Posts\Admin;

use Brickrouge\ListViewColumn;

class CreatedColumn extends ListViewColumn
{
	public function render_cell($row)
	{
		return $row->created->format('m/d/Y H:i');
	}
}
