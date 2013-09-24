<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => array('post')));

		if (!Cache::has('sidebar_categories')){
			$sidebar_categories = Category::orderBy('post_count')->get();
			Cache::forever('sidebar_categories', $sidebar_categories);
		}
		View::share('sidebar_categories', Cache::get('sidebar_categories'));

		if (!Cache::has('sidebar_posts')){
			$sidebar_posts = Post::orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(2)->get();
			Cache::forever('sidebar_posts', $sidebar_posts);
		}
		View::share('sidebar_posts', Cache::get('sidebar_posts'));
	}

}