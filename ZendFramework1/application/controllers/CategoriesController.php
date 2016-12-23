<?php

class CategoriesController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}


	public function showAction()
	{
		$id =  $this->_getParam('id', 0);
		$categories = new Application_Model_DbTable_Categories();
		if($category = $categories->findById($id)){
			$this->view->category = $category;
		}else{
			throw new Zend_Controller_Action_Exception('This category does not exist', 404);
		}
	}

	public function newAction()
	{
		// action body
	}


}