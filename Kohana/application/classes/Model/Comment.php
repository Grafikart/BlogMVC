<?php defined('SYSPATH') or die('No direct script access.');

class Comment extends ORM{

	protected $_belongs_to = array(
			'post' => array()
		);

}