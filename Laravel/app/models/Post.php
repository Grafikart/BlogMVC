<?php

class Post extends \Eloquent {

	protected $fillable = ['name', 'category_id', 'content', 'user_id', 'slug'];

    public static $rules = [
        'name' => 'required',
        'content' => 'required',
        'category_id' => 'required|exists:categories,id',
        'user_id' => 'required|exists:users,id',
    ];

    /**
    * Event binding using boot
    **/
    public static function boot()
    {
        parent::boot();

        static::saving(function($post){
            if(isset($post->name) && isset($post->slug) && empty($post->slug)){
                $post->slug = Str::slug($post->name);
            }
        });

        static::saved(function($post){
            if($post->category){
                $post->category->updateCount();
            }
            Cache::forget('sidebar');
        });

        static::deleted(function($post){
            if($post->category){
                $post->category->updateCount();
            }
            Cache::forget('sidebar');
        });
    }

    /**
    * URL Attribute to get URL faster
    **/
    public function getUrlAttribute()
    {
        return URL::action("PostsController@show", ['slug' => $this->slug]);
    }
    public function getAuthorUrlAttribute()
    {
        return URL::action("PostsController@author", ['user_id' => $this->user_id]);
    }
    public function getCategoryUrlAttribute()
    {
        return URL::action("PostsController@category", ['slug' => $this->category->slug]);
    }

    /**
    * Default orderBy created_at DESC
    **/
    public function newQuery()
    {
        return parent::newQuery()->orderBy('created_at', 'DESC');
    }

    /**
    * Relations
    **/
    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function comments()
    {
        return $this->hasMany('Comment');
    }

}