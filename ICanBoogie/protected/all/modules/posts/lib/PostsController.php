<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\HTTP\NotFound;
use ICanBoogie\Operation;
use ICanBoogie\Routing\ActionController;

use Brickrouge\A;
use Brickrouge\Button;
use Brickrouge\Form;
use Brickrouge\Pagination;

/**
 * @method array fetch_records() fetch_records(array $conditions)
 *
 * @property \ICanBoogie\Routing\Routes $routes
 * @property \ICanBoogie\View\View $view
 * @property \ICanBoogie\ActiveRecord\Fetcher $records_fetcher
 */
class PostsController extends ActionController
{
	const LIMIT = 5;

	protected function action_index()
	{
		$request = $this->request;

		$this->view->content = $this->fetch_records([ 'limit' => self::LIMIT, 'order' => '-created' ] + $request->params);
		$this->view['pagination'] = new Pagination([

			Pagination::COUNT => $this->records_fetcher->count,
			Pagination::LIMIT => self::LIMIT,
			Pagination::POSITION => $request['page']

		]);
	}

	protected function action_show()
	{
		$records = $this->fetch_records([ 'limit' => 1, 'order' => 'created' ] + $this->request->params);

		if (!$records)
		{
			throw new NotFound;
		}

		$this->view->content = current($records);
	}

	protected function action_admin()
	{
		$this->action_index();

		$this->view->content = new Admin([

			Admin::ROWS => $this->view->content

		]);

		$this->view['new_link'] = new A("Add a new post", $this->routes['admin:posts:new'], [

			'class' => "btn btn-primary"

		]);
	}

	protected function action_new()
	{
		$this->view->content = new EditForm;
		$this->view['title'] = "Edit post";
		$this->view['back_link'] = new A("< Back to posts", $this->routes['admin:posts:index']);
	}

	protected function action_edit($id)
	{
		$post = $this->model[$id];
		$values = $this->request->params + $post->to_array();

		$this->action_new();
		$this->view->content[Form::VALUES] = $values;
	}

	protected function action_delete($id)
	{
		$post = $this->model[$id];

		$this->view->content = new Form([

			Form::ACTIONS => [

				new Button("Delete", [ 'class' => 'btn btn-danger', 'type' => 'submit' ])

			],

			Form::HIDDENS => [

				Operation::DESTINATION => 'posts',
				Operation::NAME => 'delete',
				Operation::KEY => $id

			]

		]);

		$this->view['post'] = $post;
	}
}
