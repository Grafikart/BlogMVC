<?php defined('SYSPATH') or die('No direct script access.');

class Model_Post extends ORM{

	protected $_belongs_to = array(
			'category' => array(),
			'user'     => array()
		);

	protected $_has_many = array(
			'comments' => array()
		);

}