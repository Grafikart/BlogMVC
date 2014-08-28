<?php

class UsersController extends BaseController {

    public function login() {
        $this->layout->nest('content', 'users.login');
    }

    public function doLogin() {
        $username = Input::get('username');
        $password = Input::get('password');
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return Redirect::intended();
        } else {
            return Redirect::back()->with('error', 'Incorrect Username or Password');
        }
        $this->layout->nest('content', 'users.login');
    }

    public function logout() {
        Auth::logout();
        return Redirect::to("/");
    }

}