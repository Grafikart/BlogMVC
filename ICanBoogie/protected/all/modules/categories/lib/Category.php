<?php

namespace BlogMVC\Modules\Categories;

use ICanBoogie\Routing\ToSlug;

class Category extends \ICanBoogie\ActiveRecord implements ToSlug
{
	public $id;
	public $name;
	public $slug;
	public $post_count;

	public function __toString()
	{
		return $this->name;
	}

	public function to_slug()
	{
		return $this->slug;
	}
}
