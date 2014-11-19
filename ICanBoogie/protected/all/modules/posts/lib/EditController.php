<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\HTTP\Request;

use Brickrouge\Form;

class EditController extends NewController
{
	private $request;

	protected function lazy_get_values()
	{
		$id = $this->request['id'];
		$post = $this->app->models['posts'][$id];

		return $this->request->params + $post->to_array();
	}

	protected function lazy_get_form()
	{
		$form = parent::lazy_get_form();
		$form[Form::VALUES] = $this->values;

		return $form;
	}

	public function __invoke(Request $request)
	{
		$this->request = $request;

		return parent::__invoke($request);
	}
}
