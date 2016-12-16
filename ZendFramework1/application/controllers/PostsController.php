<?php

class PostsController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$this->view->title = "Posts#Index";
		$post = new Application_Model_PostMapper();
		$this->view->entries = $post->fetchAll();
	}

	

	public function showAction()
	{
		$this->view->title = $this->fetchPost()->name;
	}

	public function newAction()
	{
		$this->view->title = "Posts#New";
		$form    = new Application_Form_Post();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {

				$post = new Application_Model_Post($form->getValues());

				$mapper  = new Application_Model_PostMapper();
				$mapper->save($post);
				return $this->_helper->redirector('index');
			}
		}

		$this->view->form = $form;
	}

	public function editAction()
	{
		// get the post
		$post = $this->fetchPost();

		$form    = new Application_Form_Post();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				$post = new Application_Model_Post($form->getValues());

				$mapper  = new Application_Model_PostMapper();
				$mapper->save($post);
				return $this->_helper->redirector('index');
			}
		}else{
			$this->view->title = 'Edit '.$post->name;
			$form->populate($post->formData());
			$this->view->form = $form;
		}

		
	}
	/**
	 * Get the post from param GET id and set in view
	 * throw an error if not found
	 */
	private function fetchPost(){
		$id =  $this->_getParam('id', 0);
		if($post = Application_Model_Post::from_id($id)){
			$this->view->post = $post;
			return $post;
		}else{
			throw new Zend_Controller_Action_Exception('This post does not exist', 404);
		}
	}

}
