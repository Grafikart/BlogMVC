<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if(isset($_SESSION['admin'])){

        }else{
        	return $this->_helper->redirector('login');
        }
    }

    public function loginAction()
    {

        $this->view->title = "Admin";
        $this->view->form = new Application_Form_Admin();
    }


}





