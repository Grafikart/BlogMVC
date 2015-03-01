<?php

namespace BlogMVC\Modules\Comments;

class Hooks
{
	static public function markup_comments_submit(array $args, $engine, $template)
	{
		$form = new SubmitForm([

			SubmitForm::POST_ID => $args['post']->id,
			SubmitForm::VALUES => \ICanBoogie\app()->request->params

		]);

		return $template ? $engine($template, $form) : $form;
	}
}
