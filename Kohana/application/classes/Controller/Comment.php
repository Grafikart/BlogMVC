<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Template{

	public $template = 'layouts/blog';

	public function action_create_comment(){

		$slug = $this->request->param('post_slug');
		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		$comment = ORM::factory('Comment');
		$comment->post_id = $post->id;
		$comment->created = DB::expr('NOW()');
		$comment->values($_POST , array('username' , 'mail' , 'content'));

		try{

			$comment->save();

		} catch( ORM_Validation_Exception $e){
			Session::instance()->set('flash_errors' , array_keys($e->errors()));
			$this->redirect('post/' . $post->slug);

		}

		$this->redirect('post/' . $post->slug);
	}

}