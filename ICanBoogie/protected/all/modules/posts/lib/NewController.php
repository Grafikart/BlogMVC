<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\Controller;
use Brickrouge\A;

class NewController extends Controller
{
	protected function lazy_get_title()
	{
		return "Edit post";
	}

	protected function lazy_get_back_link()
	{
		return new A("< Back to posts", $this->app->routes['admin:posts:index']);
	}

	protected function lazy_get_form()
	{
		return new EditForm;
	}

	public function __invoke(Request $request)
	{
		return <<<EOT
<h1>$this->title</h1>
<p>$this->back_link</p>
$this->form
EOT;
	}
}
