<?php

class CommentsController extends BaseController {

    protected $comment;

    public function __construct(Comment $comment) {
        parent::__construct();
        $this->comment = $comment;
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store() {
        $inputs     = Input::all();
        $validation = $this->comment->validate($inputs);

        if ( ! $validation->passes() ) {
            return Redirect::back()->withErrors($validation->errors())->withInput($inputs)->with("alert_error" , "Oops Something Wrong");
        }

        $comment           = new Comment();
        $comment->post_id  = Input::get('post_id');
        $comment->username = Input::get('username');
        $comment->mail     = Input::get('email');
        $comment->content  = Input::get('content');
        $comment->created  = new DateTime;

        if ( $comment->save() ) {
            return Redirect::back();
        }
    }
}
