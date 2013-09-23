<?php
class UsersController extends AppController{

    public function login(){
        if(!empty($this->request->data)){
            if($this->Auth->login()){
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function admin_login(){
        return $this->redirect(array('action' => 'login', 'admin' => false));
    }

}