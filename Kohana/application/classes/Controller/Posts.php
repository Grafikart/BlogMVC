<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Posts extends Controller_Template{

	public $template = 'layouts/blog';

	public function action_index(){

		$posts = ORM::factory('Post')
			->order_by('created','DESC')
			->limit(5)
			->find_all();

		$this->template->content = View::factory('blog/index')->bind('posts',$posts);

		$this->response->body($this->template);
	}

}