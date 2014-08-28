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

$id   = '[0-9]+';
$slug = '[a-z0-9\-]+';

// Filters
Route::when('*', 'csrf', array('post', 'put', 'delete'));

// Back-end (first to avoid conflict)
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function(){
    // Back-end homepage will be posts listing
    Route::get('/', 'Admin\PostsController@index');
    Route::resource('posts', 'Admin\PostsController', ['except' => ['index']]);
});

// Homepage
Route::get('/', 'PostsController@index');

// User
Route::get('/login', 'UsersController@login');
Route::get('/logout', 'UsersController@logout');
Route::post('/login', 'UsersController@doLogin');

// Blog
Route::get('/category/{slug}', 'PostsController@category')->where('slug', $slug);
Route::get('/author/{user_id}', 'PostsController@author')->where('user_id', $id);
Route::get('/{slug}', 'PostsController@show')->where('slug', $slug);

// Comments
Route::resource('comments', 'CommentsController', ['only' => 'store']);
