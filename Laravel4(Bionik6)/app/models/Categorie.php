<?php

class Categorie extends Eloquent {

    protected $guarded = array ();

    public static $rules = array ();

    public function posts() {
       return  $this->hasMany("Post");
    }
}
