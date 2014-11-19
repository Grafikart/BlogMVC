<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\HTTP\NotFound;
use ICanBoogie\HTTP\Request;
use ICanBoogie\ActiveRecord\Fetcher;
use ICanBoogie\Routing\Controller;

use BlogMVC\Controller\RenderTrait;

class ViewController extends Controller
{
	use RenderTrait;

	private $request;
	private $fetcher;
	private $records;

	public function __invoke(Request $request)
	{
		$this->request = $request;
		$this->fetcher = $fetcher = new Fetcher($this->app->models['posts']);
		$records = $fetcher([ 'limit' => 1, 'order' => 'created' ] + $request->params);

		if (!$records)
		{
			throw new NotFound;
		}

		$this->data = current($records);

		return $this->render();
	}

	protected function get_template_pathname()
	{
		return DIR . 'templates/view.html';
	}
}
