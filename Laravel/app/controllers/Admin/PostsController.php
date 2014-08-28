<?php
namespace Admin;

use Input;
use Post;
use Redirect;
use Validator;

class PostsController extends BaseController{

    public function index()
    {
        $posts = Post::with('category')->paginate(25);
        $this->layout->nest('content', 'admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post();
        $this->layout->nest('content', 'admin.posts.edit', compact('post'));
    }

    public function store()
    {
        $datas = Input::only('category_id', 'content', 'user_id', 'name', 'slug');

        $validator = Validator::make($datas, Post::$rules);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Post::create($datas);
        return Redirect::action('Admin\PostsController@index')->with(array('success' => "Post created with success"));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->layout->nest('content', 'admin.posts.edit', compact('post'));
    }

    public function update($id)
    {
        $post = Post::findOrFail($id);
        $datas = Input::only('category_id', 'content', 'user_id', 'name', 'slug');

        $validator = Validator::make($datas, Post::$rules);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $post->update($datas);
        return Redirect::action('Admin\PostsController@index')->with(array('success' => "Post edited with success"));
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return Redirect::action('Admin\PostsController@index')->with(array('success' => "Post has been deleted"));
    }
}