<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\ActiveRecord\Criterion;
use ICanBoogie\ActiveRecord\Query;

class CategoryCriterion extends Criterion
{
	public function alter_query_with_value(Query $query, $value)
	{
		$categories = \ICanBoogie\app()->models['categories']
		->select('`id` AS category_id, `slug` AS category_slug');

		return $query->join($categories, [ 'on' => 'category_id' ])->filter_by_category_slug($value);
	}
}
