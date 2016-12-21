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

        }else{
        	return $this->_helper->redirector('login');
        }
    }

    public function loginAction()
    {
        $form = new Application_Form_Admin();
        $request = $this->getRequest();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $users = new Application_Model_DbTable_Users();
                $user = $users->findByUsername($_POST['username']);
                $session_admin = new Zend_Session_Namespace('admin');
                $session_admin->id = $user->getId();
                return $this->_helper->redirector('index');
            }
        }
        $this->view->title = "Admin";
        $this->view->form = $form;
    }


}





