<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template{

	public $template = 'layouts/blog';

	public function before(){
		if(!Auth::instance()->logged_in()){
			$this->redirect('login');
		}

		parent::before();
	}

}