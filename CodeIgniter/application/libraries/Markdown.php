<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Markdown extends \Michelf\Markdown {

	public function __construct()
	{
		parent::__construct();
		// configure markdown plugin here, see https://michelf.ca/projects/php-markdown/configuration/
	}

	public function apply($content) 
	{
		// apply custom behaviour here
		return parent::transform($content);
	}
}

/* End of file Markdown.php */
/* Location: ./application/libraries/Markdown.php */