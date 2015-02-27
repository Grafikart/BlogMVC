<?php

namespace BlogMVC\Modules\Categories;

use ICanBoogie\Routing\ActionController;
use ICanBoogie\Routing\Route;

class CategoriesController extends ActionController
{
	protected function action_show()
	{
		return $this->forward_to($this->routes['posts:category']);
	}
}
