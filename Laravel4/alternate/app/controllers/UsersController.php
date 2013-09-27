<?php

class UsersController extends BaseController {

    public function __construct() {
        $this->beforeFilter("csrf" , ["on" => "post"]);
    }

    public function login() {
        return View::make('home.login')->with("title" , "Login");
    }

    public function postLogin() {
        $creds = ['username' => Input::get('username') ,
                  'password' => Input::get('password')];
        $validation = User::validate($creds);

        if ( $validation->passes() ) {
            return (Auth::attempt($creds , true)) ? Redirect::route("admin.index")
                    : Redirect::back()->with("alert_error" , "Bad Credentials");
        }
        return Redirect::back()->with("alert_error" , "Username or Password can't be empty");
    }

    public function logout() {
        Auth::logout();
        return Redirect::route("home.index");
    }
}
