<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends ORM{

	protected $_has_many = array(
			'posts' => array()
		);

}