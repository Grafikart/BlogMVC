<?php
class GuestController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('guest');
    }

    public function getLogin()
    {
        return View::make('auth.login');
    }

    public function postLogin()
    {
        $input = array('username' => Input::get('username'), 'password' => Input::get('password'));

        if (Auth::attempt($input)) {
            return Redirect::route('admin');
        }else{
            return Redirect::route('login')->withInput(Input::except('password'))->with('flash_error', 'admin/admin');
        }
    }

}