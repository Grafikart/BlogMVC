<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\Controller;
use ICanBoogie\ActiveRecord\Fetcher;

use Brickrouge\Pagination;

use BlogMVC\Controller\RenderTrait;

class ListController extends Controller
{
	use RenderTrait;

	const LIMIT = 5;

	private $request;
	private $fetcher;
	private $data;

	public function __invoke(Request $request)
	{
		$this->request = $request;
		$this->fetcher = $fetcher = new Fetcher($this->app->models['posts']);
		$this->data = $fetcher([ 'limit' => self::LIMIT, 'order' => '-created' ] + $request->params);

		return $this->render();
	}

	protected function get_template_pathname()
	{
		return DIR . 'templates/list.html';
	}

	protected function get_template_variables()
	{
		$pagination = new Pagination([

			Pagination::COUNT => $this->fetcher->count,
			Pagination::LIMIT => self::LIMIT,
			Pagination::POSITION => $this->request['page']

		]);

		return [

			'pagination' => $pagination

		];
	}
}
