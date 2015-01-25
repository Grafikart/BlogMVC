<?php

namespace BlogMVC\Modules\Categories;

use ICanBoogie\Operation;

use BlogMVC\Modules\Posts;

class Hooks
{
	static private function update_post_count()
	{
		$models = \ICanBoogie\app()->models;

		$count = $models['posts']
			->select('COUNT(id)')
			->group('category_id')
			->where('category_id = categories.id');

		$models['categories']("UPDATE {self} SET post_count = IFNULL(($count), 0)");
	}

	/*
	 * Events
	 */

	/**
	 * Update the `post_count` column when posts are saved.
	 *
	 * @param Operation\ProcessEvent $event
	 * @param Posts\SaveOperation $target
	 */
	static public function on_posts_save(Operation\ProcessEvent $event, Posts\SaveOperation $target)
	{
		self::update_post_count();
	}

	/**
	 * Update the `post_count` column when posts are deleted.
	 *
	 * @param Operation\ProcessEvent $event
	 * @param Posts\DeleteOperation $target
	 */
	static public function on_posts_delete(Operation\ProcessEvent $event, Posts\DeleteOperation $target)
	{
		self::update_post_count();
	}

	/*
	 * Markups
	 */

	static public function markup_category_home(array $args, \Patron\Engine $patron, $template)
	{
		$bind = \ICanBoogie\app()->models['categories']->order('name')->all;

		return $patron($template, $bind);
	}
}
