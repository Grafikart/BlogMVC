<?php

namespace BlogMVC\Modules\Comments;

use BlogMVC\CreatedProperty;

class Comment extends \ICanBoogie\ActiveRecord
{
	use CreatedProperty;

	public $id;
	public $post_id;
	public $username;
	public $mail;
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

	protected function get_author()
	{
		return CommentAuthor::from($this->username);
	}
}
