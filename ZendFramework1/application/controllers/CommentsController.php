<?php

class CommentsController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}


	public function createAction()
	{

		$form    = new Application_Form_Comment();
		$request = $this->getRequest();

		$post_id =  $this->_getParam('id', 0);

		if ($post_id && $request->isPost()) {
			if ($form->isValid($request->getPost())) {
				//create a post with form value and session id
				$comment = new Application_Model_Comment($form->getValues());
				$comment->setPostId($post_id);

				$comments = new Application_Model_DbTable_Comments();
				$comments->save($comment);
				return $this->_helper->getHelper('Redirector')
					->gotoRoute(array('slug' => $comment->post()->getSlug() ), 'view_post');
			}
		}
	}
}