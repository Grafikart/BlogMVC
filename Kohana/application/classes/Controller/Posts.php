<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Posts extends Controller_Template{

	public $template = 'layouts/blog';

	public function action_index(){

		$posts = ORM::factory('Post')
			->order_by('created','DESC')
			->limit(5)
			->find_all();

		View::bind_global('posts',$posts);

		$this->template->content = View::factory('blog/index');
	}

	public function action_show(){

		$slug = $this->request->param('slug');
		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		$comments = $post->comments->find_all();

		$data = array(
			'post'        => $post,
			'nb_comments' => $comments->count(),
			'comments'    => $comments
        );

		$this->template->title = $post->name;

        $this->template->content = View::factory('blog/post' , $data);

		
	}

	public function action_category(){

		$slug = $this->request->param('category');
		$category = ORM::factory('Category')
			->where('category.slug','=',$slug)
			->find();

		if(!$category->loaded()){
			throw HTTP_Exception::factory(404);
		}

        $data = array(
            'category' => $category,
            'posts'    => $category->posts->find_all()
        );

		$this->template->title = $category->name;

        $this->template->content = View::factory('blog/category' , $data);

	}

	public function action_author(){

		$slug = $this->request->param('user');
		$user = ORM::factory('User')
			->where('user.id','=',$slug)
			->find();

		if(!$user->loaded()){
			throw HTTP_Exception::factory(404);
		}

        $data = array(
            'user' => $user,
            'posts'    => $user->posts->find_all()
        );

		$this->template->title = $user->username;

        $this->template->content = View::factory('blog/author' , $data);

	}

}