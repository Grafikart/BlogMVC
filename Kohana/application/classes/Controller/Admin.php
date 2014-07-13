<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template{

	public $template = 'layouts/blog';

	public function before(){
		if(!Auth::instance()->logged_in() 
			&& $this->request->action() != 'get_login'
			&& $this->request->action() != 'post_login'){
			$this->redirect('login');
		}

		if($this->request->action() != 'post_login') parent::before(); //pas besoin de créer une vue pour ce cas
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

}