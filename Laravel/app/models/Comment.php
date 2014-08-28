<?php

class Comment extends \Eloquent {

	protected $fillable = ["post_id", "username", "email", "content"];

    public static $rules = [
        'username'    => 'required',
        'email'    => 'required|email',
        'post_id' => 'required|exists:posts,id',
        'content'   => 'required'
    ];


    /**
    * Default orderBy created_at DESC
    **/
    public function newQuery()
    {
        return parent::newQuery()->orderBy('created_at', 'DESC');
    }

}