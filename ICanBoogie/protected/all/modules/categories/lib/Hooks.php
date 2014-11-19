<?php

namespace BlogMVC\Modules\Categories;

class Hooks
{
	static public function markup_category_home(array $args, \Patron\Engine $patron, $template)
	{
		$bind = \ICanBoogie\app()->models['categories']->order('name')->all;

		return $patron($template, $bind);
	}
}
