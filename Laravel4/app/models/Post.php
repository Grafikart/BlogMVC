<?php

class Post extends Eloquent {
	protected $guarded = array();

	private $rules = array(
		'name' => 'required',
		'slug' => 'required|unique:posts',
		'category_id' => 'exists:categories,id',
		'user_id' => 'exists:users,id',
		'content' => 'required',
	);

	public static $sluggable = array(
		'build_from' => 'name',
		'save_to'    => 'slug',
	);

	public function category()
	{
		return $this->belongsTo('Category');
	}

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function comments()
	{
		return $this->hasMany('Comment');
	}

	public function validate($data, $rules = array())
	{
		$rules = array_merge($this->rules, $rules);

		$v = Validator::make($data, $rules);

		if ($v->fails())
		{
			$this->errors = $v->messages();
			return false;
		}

		return $v->passes();
	}

	public function errors()
	{
		return $this->errors;
	}
}
