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

	static public function markup_comments(array $args, $engine, $template)
	{
		if (!$template)
		{
			$template = file_get_contents(DIR . 'templates/list.html');
		}

		$comments = $args['post']->comments->all;

		$engine->context['count'] = count($comments);

		return $engine($template, $comments);
	}
}
