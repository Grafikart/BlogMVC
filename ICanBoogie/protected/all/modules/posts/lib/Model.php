<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\ActiveRecord\Query;

class Model extends \ICanBoogie\ActiveRecord\Model
{
	public function save(array $properties, $key=null, array $options=[])
	{
		if (empty($properties['slug']))
		{
			$properties['slug'] = \ICanBoogie\normalize($properties['name']);
		}

		return parent::save($properties, $key, $options);
	}

	protected function scope_ordered(Query $query, $direction=-1)
	{
		return $query->order('created ' . ($direction < 0 ? 'DESC' : 1));
	}
}
