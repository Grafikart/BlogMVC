<?php

class PostsController extends BaseController {

    protected $post;
    protected $comment;
    protected $categorie;
    private $cache;

    public function __construct(Post $post , Categorie $cat , Comment $comment , BlogCache $cache) {
        parent::__construct();
        $this->beforeFilter("admin" , ["except" => "show"]);
        $this->post      = $post;
        $this->categorie = $cat;
        $this->comment   = $comment;
        $this->cache     = $cache;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $categories = $this->categorie->all();
        $title      = "New Post";

        return View::make('posts.create' , compact("categories" , "title"));
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store() {
        $inputs     = Input::all();
        $validation = $this->post->validate($inputs);

        if ( $validation->passes() ) {
            $post              = new Post;
            $post->category_id = Input::get('categorie');
            $post->user_id     = Auth::user()->id;
            $post->name        = Input::get('name');
            $post->slug        = Input::get('slug');
            $post->content     = Input::get('content');
            $post->created     = new DateTime;
            if ( $post->save() ) {
                $this->cache->destroy();
                return Redirect::route("admin.index");
            }
        }
        return Redirect::back()->withInput($inputs)
                       ->withErrors($validation->errors())
                       ->with("alert_error" , "Something Wrong :(");
    }

    /**
     * @param $post_slug
     * @return \Illuminate\View\View
     */
    public function show($post_slug) {
        $post     = $this->post->with("Categorie")->with("User")
                               ->where("slug" , "=" , $post_slug)->first();
        $comments = $this->comment->where("post_id" , "=" , $post->id)->get();
        $title    = "Post";

        return View::make('posts.show' , compact("post" , "comments" , "title"));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $title      = "Edit Post";
        $post       = $this->post->find($id);
        $categories = $this->categorie->all();
        $cats       = [];
        foreach ( $categories as $category ) {
            $cats[$category->id] = $category->name;
        }

        return View::make('posts.edit' , compact("post" , "cats" , "title"));
    }

    /**
     * Update the specified resource in storage.
     * @param  int $id
     * @return Response
     */
    public function update($id) {
        $inputs     = Input::all();
        $validation = $this->post->validate($inputs);

        if ( $validation->passes() ) {
            $post              = $this->post->find($id);
            $post->category_id = Input::get('categorie');
            $post->name        = Input::get('name');
            $post->slug        = Input::get('slug');
            $post->content     = Input::get('content');

            if ( $post->save() ) {
                return Redirect::route("admin.index");
            }
        }
        return Redirect::back()->withInput($inputs)
                       ->withErrors($validation->errors())
                       ->with("alert_error" , "Something Wrong :(");
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        $this->comment->where("post_id" , "=" , $id)->delete();
        $this->post->find($id)->delete();
        $this->cache->destroy();
        return Redirect::action("AdminController@index");
    }
}
