<?php

class Comment extends Eloquent {
	protected $guarded = array();

	private $rules = array(
		'username' => 'required',
		'email' => 'required|email',
		'content' => 'required',
	);

	private $errors;

	public function posts()
	{
		return $this->hasMany('Post');
	}

	public function scopeCount($query)
	{
		return $query->count();
	}

	public function validate($data)
	{
		$v = Validator::make($data, $this->rules);

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
