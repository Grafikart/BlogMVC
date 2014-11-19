<?php

namespace BlogMVC\Modules\Posts;

use BlogMVC\CreatedProperty;

class Post extends \ICanBoogie\ActiveRecord
{
	const MODEL_ID = 'posts';

	use CreatedProperty;

	public $id;
	public $category_id;
	public $user_id;
	public $name;
	public $slug;
	public $content;

	public function __toString()
	{
		try
		{
			return (string) $this->render();
		}
		catch (\Exception $e)
		{
			return \Brickrouge\render_exception($e);
		}
	}

	public function render()
	{
		return \Textmark_Parser::parse($this->content);
	}
}
