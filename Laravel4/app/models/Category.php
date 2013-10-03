<?php

class Category extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public static $sluggable = array(
		'build_from' => 'name',
		'save_to'    => 'slug',
	);

	public function posts()
	{
		return $this->hasMany('Post');
	}
}
