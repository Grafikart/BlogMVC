<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\ActiveRecord\Fetcher;
use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\Controller;

use Brickrouge\A;
use Brickrouge\Pagination;

class AdminController extends Controller
{
	const LIMIT = 5;

	public function __invoke(Request $request)
	{
		$fetcher = new Fetcher($this->app->models['posts']);
		$records = $fetcher([ 'limit' => self::LIMIT, 'order' => '-created' ] + $request->params);

		$listview = new Admin([

			Admin::ROWS => $records

		]);

		$new_link = new A("Add a new post", $this->app->routes['admin:posts:new'], [

			'class' => "btn btn-primary"

		]);

		$pagination = new Pagination([

			Pagination::COUNT => $fetcher->count,
			Pagination::LIMIT => self::LIMIT,
			Pagination::POSITION => $request['page']

		]);

		return <<<EOT
<h1>Manage posts</h1>
<p>$new_link</p>
$listview
$pagination
EOT;
	}
}
