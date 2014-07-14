<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template{

	public $template = 'layouts/blog';

	public function before(){
		if(!Auth::instance()->logged_in() 
			&& $this->request->action() != 'get_login'
			&& $this->request->action() != 'post_login'){
			$this->redirect('login');
		}

		parent::before();
	}

	protected function clear_cache(){
		Kohana::cache('sidebar_categories',NULL);
		Kohana::cache('sidebar_posts', NULL);
	}

	public function action_get_login(){

		$this->template->title = 'Login';
		$this->template->content = View::factory('admin/login');

	}

	public function action_post_login()
	{
		if(Auth::instance()->login( $this->request->post('username') , $this->request->post('password') )){

			$this->redirect('admin');

		} else {
			Session::instance()->set('flash_error' , TRUE );
			$this->redirect('login');
		}
	}

	public function action_index(){
		$posts = ORM::factory('Post')
			->order_by('post.created' , 'DESC')
			->limit(5)
			->find_all();

		$this->template->title = 'Admin';
		$this->template->content = View::factory('admin/index')->set('posts' , $posts);
	}

	public function action_get_create(){
		$data = array(
			'categories' => ORM::factory('Category')->order_by('name')->find_all()->as_array('id' , 'name'),
			'authors'    => ORM::factory('User')->order_by('username')->find_all()->as_array('id' , 'username')
			);

		$this->template->title = 'Add a new post';
		$this->template->content = View::factory('admin/create' , $data);
	}

	public function action_post_create(){
		$post = ORM::factory('Post');

		$post->values($this->request->post() , array('name' , 'slug' , 'category_id' , 'user_id' , 'content'));
		$post->created = DB::expr('NOW()');

		try{
			$post->save();
			$this->clear_cache();
			$this->redirect('admin');
		} catch (ORM_Validation_Exception $e){
			Session::instance()->set('flash_errors' , $e->errors());
			$this->redirect('admin/create');
		}
	}

	public function action_get_edit(){
		$slug = $this->request->param('post_slug');

		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		$data = array(
			'post'       => $post,
			'categories' => ORM::factory('Category')->order_by('name')->find_all()->as_array('id' , 'name'),
			'authors'    => ORM::factory('User')->order_by('username')->find_all()->as_array('id' , 'username')
			);

		$this->template->title = "Edit " . $post->name;
		$this->template->content = View::factory('admin/edit' , $data);
	}

	public function action_post_edit(){
		$slug = $this->request->param('post_slug');

		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		$post->values($this->request->post() , array('name' , 'slug' , 'category_id' , 'user_id' , 'content'));

		try{
			$post->save();
			$this->clear_cache();
			$this->redirect('admin');
		} catch (ORM_Validation_Exception $e){
			Session::instance()->set('flash_errors' , $e->errors());
			$this->redirect('admin/edit/' . $slug);
		}
	}

	public function action_get_delete(){
		$slug = $this->request->param('post_slug');

		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		$post->delete();

		$this->redirect('admin');
	}

}