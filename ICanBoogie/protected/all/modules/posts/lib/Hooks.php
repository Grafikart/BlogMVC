<?php

namespace BlogMVC\Modules\Posts;

class Hooks
{
	static public function markup_posts_latests(array $args, $engine, $template)
	{
		$bind = \ICanBoogie\app()->models['posts']->ordered->limit(5)->all;

		return $engine($template, $bind);
	}
}
