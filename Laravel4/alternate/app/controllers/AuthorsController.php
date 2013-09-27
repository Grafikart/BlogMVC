<?php

class AuthorsController extends BaseController {

    protected $post;

    public function __construct(Post $post) {
        parent::__construct();
        $this->post = $post;
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id) {

        $posts = $this->post->with("User")->where("user_id" , "=" , $id)
                            ->orderBy("created" , "desc")->paginate(3);
        $title = "Author";

        return View::make('authors.show' , compact("posts" , "title"));
    }
}
