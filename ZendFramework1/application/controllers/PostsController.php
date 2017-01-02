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

		$posts = new Application_Model_DbTable_Posts();
		$this->view->posts = $posts->all();

		$categories = new Application_Model_DbTable_Categories();
		$this->view->categories = $categories->all();
		$this->view->last_posts = $posts->all(5);
	}

	public function showAction()
	{
		$posts = new Application_Model_DbTable_Posts();
		$categories = new Application_Model_DbTable_Categories();

		$this->view->title     = $this->fetchPostBySlug()->name;
		$this->view->form       = new Application_Form_Comment();
		$this->view->categories = $categories->all();
		$this->view->last_posts = $posts->all(5);
	}

	public function newAction()
	{
		$this->checkAdmin();

		$this->view->title = "Posts#New";
		$form    = new Application_Form_Post();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				//create a post with form value and session id
				$post = new Application_Model_Post($form->getValues());
				$session_admin = new Zend_Session_Namespace('admin');
				$post->setUserId($session_admin->id);


				$posts = new Application_Model_DbTable_Posts();
				$posts->save($post);
				return $this->_helper->redirector('index');
			}
		}

		$this->view->form = $form;
	}

	public function editAction()
	{
		$this->checkAdmin();

		// get the post
		$post = $this->fetchPostById();

		$form    = new Application_Form_Post();
		$request = $this->getRequest();

		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$post = new Application_Model_Post($form->getValues());

				$session_admin = new Zend_Session_Namespace('admin');
				$post->setUserId($session_admin->id);

				$posts = new Application_Model_DbTable_Posts();
				$posts->save($post);
				return $this->_helper->redirector('index');
			}
		}else{
			$this->view->title = 'Edit '.$post->name;
			$form->populate($post->formData());
			$this->view->form = $form;
		}
	}

	public function deleteAction()
	{
		$this->checkAdmin();

		// get the post
		$post = $this->fetchPostById();

		
		$posts = new Application_Model_DbTable_Posts();
		$posts->deletePost( $this->view->post );
		return $this->_helper->redirector('index');
		
	}


	/**
	 * Get the post from param GET id and set in view
	 * throw an error if not found
	 */
	private function fetchPostById()
	{
		$id =  $this->_getParam('id', 0);
		$posts = new Application_Model_DbTable_Posts();
		return $this->fetchPost( $posts->findById( $id) );
	}

	/**
	 * Get the post from param GET slug and set in view
	 * throw an error if not found
	 */
	private function fetchPostBySlug()
	{
		$slug =  $this->_getParam('slug', 0);
		$posts = new Application_Model_DbTable_Posts();
		return $this->fetchPost( $posts->findBy('slug', $slug) );
	}

	private function fetchPost($post)
	{
		if($post){
			$this->view->post = $post;
			return $post;
		}else{
			throw new Zend_Controller_Action_Exception('This post does not exist', 404);
		}
	}

	/**
	 * Throw a 403 error if user isn't logged
	 */
	private function checkAdmin()
	{
		$session_admin = new Zend_Session_Namespace('admin');
		if(!isset($session_admin->id)){
			throw new Zend_Controller_Action_Exception('Oh crap, you are not logged as admin..', 403);
		}
	}
}


