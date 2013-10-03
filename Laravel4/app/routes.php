<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::bind('post_slug', function($value, $route){
    return Post::where('slug', $value)->first();
});
Route::bind('category_slug', function($value, $route){
    return Category::where('slug', $value)->first();
});
Route::model('user_id', 'User');


Route::get('/', array('uses' => 'BlogController@getIndex', 'as' => 'home'));

Route::get('post/{post_slug}', array('uses' => 'BlogController@getPost', 'as' => 'post'));

Route::get('category/{category_slug}', array('uses' => 'BlogController@getCategory', 'as' => 'category'));

Route::get('author/{user_id}', array('uses' => 'BlogController@getAuthor', 'as' => 'author'));

Route::post('comment/{post_slug}', array('uses' => 'CommentController@postCreate', 'as' => 'comment.post'));

Route::get('login', array('uses' => 'GuestController@getLogin', 'as' => 'login'));
Route::post('login', array('uses' => 'GuestController@postLogin', 'as' => 'login.post'));

Route::group(array('prefix' => 'admin'), function(){
	Route::get('/', array('uses' => 'AdminController@getIndex', 'as' => 'admin'));
	Route::get('post/create', array('uses' => 'AdminController@getCreate', 'as' => 'admin.create'));
	Route::post('post/create', array('uses' => 'AdminController@postCreate', 'as' => 'admin.create.post'));
	Route::get('post/edit/{post_slug}', array('uses' => 'AdminController@getUpdate', 'as' => 'admin.edit'));
	Route::post('post/edit/{post_slug}', array('uses' => 'AdminController@postUpdate', 'as' => 'admin.edit.post'));
	Route::get('post/delete/{post_slug}', array('uses' => 'AdminController@getDelete', 'as' => 'admin.delete'));
});