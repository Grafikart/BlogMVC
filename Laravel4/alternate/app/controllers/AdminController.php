<?php

class AdminController extends BaseController {

    protected $post;
    protected $comment;

    public function __construct(Post $post , Comment $comment) {
        parent::__construct();
        $this->post    = $post;
        $this->comment = $comment;
        $this->beforeFilter("admin");
    }



    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $posts = $this->post->with("Categorie")
                            ->where("user_id" , Auth::user()->id)
                            ->orderBy("created" , "desc")->paginate(2);

        return View::make('admin.index' , compact("posts"))
                   ->with("title" , "Administration");
    }
}
