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

	public function action_get_login(){

		$this->template->title = 'Login';
		$this->template->content = View::factory('admin/login');

	}

}