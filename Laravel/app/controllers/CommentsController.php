<?php
class CommentsController extends BaseController {


    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store() {
        $datas     = Input::all();
        $validator = Validator::make($datas, Comment::$rules);

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput()->with("error" , "Oops Something Wrong");
        }

        Comment::create($datas);
        return Redirect::back()->with('success', 'Thanks for your comment');
    }
}
