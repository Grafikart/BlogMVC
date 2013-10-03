<?php

class Comment extends BaseModel {

    protected $fillable = array ("*");

    public $timestamps = false;

    public static $rules = ["email" => "required|email" , "username" => "required|min:4" , "content" => "required|min:10"];

    public function post() {
        $this->belongsTo('Post');
    }
}
