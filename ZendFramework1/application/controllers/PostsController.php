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


}

