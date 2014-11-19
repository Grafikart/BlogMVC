<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\Controller;
use Brickrouge\Form;
use Brickrouge\Button;
use ICanBoogie\Operation;

class DeleteController extends Controller
{
	public function __invoke(Request $request)
	{
		$id = $request['id'];
		$post = $this->app->models['posts'][$id];

		$form = new Form([

			Form::ACTIONS => [

				new Button("Delete", [ 'class' => 'btn btn-danger', 'type' => 'submit' ])

			],

			Form::HIDDENS => [

				Operation::DESTINATION => 'posts',
				Operation::NAME => 'delete',
				Operation::KEY => $id

			],

			'action' => $this->app->routes['admin:posts:index']

		]);

		return <<<EOT
<h1>Delete $post->name</h1>

<p>Are you sure you want to delete <q>$post->name</q>?</p>

$form
EOT;
	}
}
