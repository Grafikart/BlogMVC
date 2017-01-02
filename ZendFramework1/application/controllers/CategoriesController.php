<?php
require_once 'AdminMiddleware.php';

class CategoriesController extends Zend_Controller_Action
{

	use AdminMiddleware;

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
		$this->checkAdmin();

		$this->view->title = "Categories#New";
		$form    = new Application_Form_Category();
		$request = $this->getRequest();

		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				//create a post with form value and session id
				$category = new Application_Model_Category($form->getValues());
				$session_admin = new Zend_Session_Namespace('admin');

				$categories = new Application_Model_DbTable_Categories();
				
				try{
					$categories->save($category);
					return $this->_helper->getHelper('Redirector')
					                    ->gotoRoute(array(), 'admin');
				}catch(Exception $e){
					$this->view->flash = array( 'warning' => "Can't create category: ".$e->getMessage() );
				}
			}
		}

		$this->view->form = $form;
	}

	public function editAction()
	{
		$this->checkAdmin();

		// get the post
		$category = $this->fetchCategoryById();

		$form    = new Application_Form_Category();
		$request = $this->getRequest();

		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$category = new Application_Model_Category($form->getValues());

				$categories = new Application_Model_DbTable_Categories();
				try{
					$categories->save($category);
					$this->view->flash = array('success' => 'Category updated');
					return $this->_helper->getHelper('Redirector')
						                    ->gotoRoute(array(), 'admin');
				}catch(Exception $e){
					$this->view->flash = array( 'warning' => "Can't create category: ".$e->getMessage() );
				}
				
			}
		}
		
		$this->view->title = 'Edit '.$category->name;
		$form->populate($category->formData());
		$this->view->form = $form;
	}

	/**
	 * Get the post from param GET id and set in view
	 * throw an error if not found
	 */
	private function fetchCategoryById()
	{
		$id =  $this->_getParam('id', 0);
		$categories = new Application_Model_DbTable_Categories();

		if($category =  $categories->findById( $id) ){
			$this->view->category = $category;
			return $category;
		}else{
			throw new Zend_Controller_Action_Exception('This category does not exist', 404);
		}
	}


}