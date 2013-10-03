<?php

class HomeController extends BaseController {

    protected $post;
    protected $category;

    public function __construct(Post $post , Categorie $cat) {
        parent::__construct();
        $this->post     = $post;
        $this->category = $cat;
    }

    public function index() {
        $posts = $this->post->with("Categorie")->with("User")->orderBy("created" , "desc")->paginate(4);
        $title = "Welcome to the Blog";

        return View::make("home.index" , compact('posts' , 'title', 's'));
    }
}
