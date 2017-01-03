<?php

trait AdminMiddleware
{
    /**
     * Throw a 403 error if user isn't logged
     */
    protected function checkAdmin()
    {
        $session_admin = new Zend_Session_Namespace('admin');
        if (!isset($session_admin->id)) {
            throw new Zend_Controller_Action_Exception('Oh crap, you are not logged as admin..', 403);
        }
    }
}
