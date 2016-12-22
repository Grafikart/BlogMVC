<?php

class UsersController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$this->view->title = "Users#Index";
		$users = new Application_Model_DbTable_Users();
		$this->view->entries = $users->all();
	}

	public function showAction()
	{
		$id =  $this->_getParam('id', 0);
		$users = new Application_Model_DbTable_Users();
		if($user = $users->findById($id)){
			$this->view->user = $user;
		}else{
			throw new Zend_Controller_Action_Exception('This user does not exist', 404);
		}
	}


}