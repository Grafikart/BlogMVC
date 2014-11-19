<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\ActiveRecord\Criterion;
use ICanBoogie\ActiveRecord\Query;

class AuthorCriterion extends Criterion
{
	public function alter_query_with_value(Query $query, $value)
	{
		$users = \ICanBoogie\app()->models['users']
		->select('id AS user_id, username');

		return $query
		->join($users, [ 'on' => 'user_id' ])
		->and("post.user_id = ? OR username = ?", $value, $value);
	}
}
