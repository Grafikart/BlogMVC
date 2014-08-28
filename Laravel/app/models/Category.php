<?php

class Category extends \Eloquent {

	protected $fillable = ['name', 'slug', 'post_count'];

    public function updateCount()
    {
        $this->post_count = $this->posts()->count();
        $this->save();
    }
    public function posts()
    {
        return $this->hasMany('Post');
    }


}