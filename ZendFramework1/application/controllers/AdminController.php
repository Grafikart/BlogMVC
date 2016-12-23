<?php

class AdminController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$session_admin = new Zend_Session_Namespace('admin');
		if(isset($session_admin->id)){
			// OH YEAH, YOU ARE CONNECTED
			$posts = new Application_Model_DbTable_Posts();
			$this->view->posts = $posts->all();
			$categories = new Application_Model_DbTable_Categories();
			$this->view->categories = $categories->all();

		}else{
			return $this->_helper->redirector('login');
		}
	}

	public function loginAction()
	{
		$form = new Application_Form_Admin();
		$request = $this->getRequest();

		// Check if request is POST & form is correct 
		if ($this->getRequest()->isPost() && $form->isValid($request->getPost() )) {
			$users = new Application_Model_DbTable_Users();
			$user = $users->findByUsername($_POST['username']);

			if($user->isPassword($_POST['password'])){
				$session_admin = new Zend_Session_Namespace('admin');
				$session_admin->id = $user->getId();
				return $this->_helper->redirector('index');

			}else{
				$this->view->error = "User doesn't exist or password don't match";
			}
			
		}
		$this->view->title = "Admin";
		$this->view->form = $form;
	}


}