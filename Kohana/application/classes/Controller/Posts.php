<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Posts extends Controller_Template{

	public $template = 'layouts/blog';

	public function action_index(){

		$posts = ORM::factory('Post')
			->order_by('created','DESC')
			->find_all();

		$paginator = Paginator::factory($posts);
		$paginator->set_item_count_per_page(5);
		$paginator->set_current_page_number(Arr::get($_GET , 'page' , 1));

		View::bind_global('posts',$paginator);

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

		$comments = $post->comments->order_by('created' , 'DESC' )->find_all();

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

		$paginator = Paginator::factory($category->posts->order_by('created','DESC')->find_all());
		$paginator->set_item_count_per_page(5);
		$paginator->set_current_page_number(Arr::get($_GET , 'page' , 1));

        $data = array(
            'category' => $category,
            'posts'    => $paginator
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

		$paginator = Paginator::factory($user->posts->order_by('created','DESC')->find_all());
		$paginator->set_item_count_per_page(5);
		$paginator->set_current_page_number(Arr::get($_GET , 'page' , 1));

        $data = array(
			'user'  => $user,
			'posts' => $paginator
        );

		$this->template->title = $user->username;

        $this->template->content = View::factory('blog/author' , $data);

	}

	public function action_post_comment(){

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