<?php

namespace BlogMVC\Controller;

trait RenderTrait
{
	public function render()
	{
		$patron = new \Patron\Engine;
		$template_pathname = $this->template_pathname;

		return $patron(file_get_contents($template_pathname), $this->data, [

			'file' => $template_pathname,
			'variables' => $this->template_variables

		]);
	}

	protected function get_template_pathname() {}

	protected function get_template_variables()
	{
		return [];
	}
}
