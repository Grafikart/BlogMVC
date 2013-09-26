<?php

class Post extends BaseModel {

    protected $fillable = array ("*");

    public $timestamps = false ;

    public static $rules = array ("name" => "required|min:3" , "content" => "required|min:10");

    public function user() {
        return $this->belongsTo('User');
    }

    public function comments() {
        return $this->hasMany('Comment');
    }

    public function categorie() {
        return $this->belongsTo("Categorie" , "category_id");
    }
}
