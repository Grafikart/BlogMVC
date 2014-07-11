<?php defined('SYSPATH') or die('No direct script access.');

class User extends ORM{

	protected $_has_many = array(
			'posts' => array()
		)

}