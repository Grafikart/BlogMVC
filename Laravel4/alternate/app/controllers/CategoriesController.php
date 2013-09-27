<?php

class CategoriesController extends BaseController {

    protected $category;
    protected $post;

    public function __construct(Categorie $cat , Post $post) {
        parent::__construct();
        $this->category = $cat;
        $this->post     = $post;
    }

    /**
     * @param $category_slug
     * @return \Illuminate\View\View
     */
    public function show($category_slug) {
        $title = "Category";
        $categorie = $this->category->where("slug", "=", $category_slug)->first(["id"]);
        $posts = $this->post->with("User")->where("category_id", "=", $categorie->id)->orderBy("created", "desc")->get();

        return View::make('categories.show', compact("posts", "categorie", "title"));
    }

}
