<?php

class AdminController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    private function cleanCache(){
        if (Cache::has('sidebar_categories')){
            Cache::forget('sidebar_categories');
        }

        if (Cache::has('sidebar_posts')){
            Cache::forget('sidebar_posts');
        }
    }

    public function getIndex(){
        $data = array();
        $data['posts'] = Post::orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(5);
        return View::make('admin.index', $data);
    }

    public function getCreate(){
        $data = array(
            'categories' => Category::orderBy('name')->lists('name', 'id'),
            'authors'    => User::orderBy('username')->lists('username', 'id')
        );
        return View::make('admin.create', $data);
    }

    public function postCreate(){
        $input = Input::all();
        $post = new Post();
        if ($post->validate($input)){
            $post->name = $input['name'];
            $post->slug = $input['slug'];
            $post->category_id = $input['category_id'];
            $post->user_id = $input['user_id'];
            $post->content = $input['content'];
            $post->save();

            $this->cleanCache();

            return Redirect::route('admin');
        }else{
            return Redirect::route('admin.create')->withInput()->withErrors($post)->with('errors', $post->errors());
        }
    }

    public function getUpdate(Post $post){
        $data = array(
			'post'       => $post,
			'categories' => Category::orderBy('name')->lists('name', 'id'),
			'authors'    => User::orderBy('username')->lists('username', 'id')
        );
        return View::make('admin.update', $data);
    }

    public function postUpdate(Post $post){
        $input = Input::all();

        $rules = array(
        	'slug' => 'required|unique:posts,id,'.$post->id
        );

        if ($post->validate($input, $rules)){
            $post->name = $input['name'];
            $post->slug = $input['slug'];
            $post->category_id = $input['category_id'];
            $post->user_id = $input['user_id'];
            $post->content = $input['content'];
            $post->save();

            return Redirect::route('admin');
        }else{
            return Redirect::to(URL::route('admin.edit', $post->slug))->withInput()->withErrors($post)->with('errors', $post->errors());
        }
    }

    public function getDelete(Post $post){
        $post->delete();
        $this->cleanCache();
        return Redirect::route('admin');
    }
}