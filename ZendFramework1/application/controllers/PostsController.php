<?php

class PostsController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$post = new Application_Model_PostMapper();
		$this->view->entries = $post->fetchAll();
	}

	public function newAction()
	{
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

}
