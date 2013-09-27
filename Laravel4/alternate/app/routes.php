<?php

Route::get('/' , ["as" => "home.index" , "uses" => "HomeController@index"]);
Route::get("users/login" , ["as" => "users.login" , "uses" => "UsersController@login"]);
Route::post("users/login" , "UsersController@postLogin");
Route::get("posts/{post_slug}" , ["as" => "posts.show" , "uses" => "PostsController@show"]);

Route::group(["prefix" => "admin"] , function () {
    Route::get('/' , ["as" => "admin.index" , "uses" => "AdminController@index"]);
    Route::get('logout' , ["as" => "admin.logout" , "uses" => "UsersController@logout"]);
    Route::get("posts/{post_id}/destroy" , ["as" => "admin.post.destroy" , "uses" => "PostsController@destroy"]);
    Route::resource("posts" , "PostsController");
});

Route::resource("comments" , "CommentsController");
Route::resource("category" , "CategoriesController");
Route::resource("authors" , "AuthorsController");

Route::filter("admin" , function () {
    if ( ! Auth::check() ) {
        return Redirect::route("users.login");
    }
});






