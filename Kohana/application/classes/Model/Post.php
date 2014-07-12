<?php defined('SYSPATH') or die('No direct script access.');

class Model_Post extends ORM{

	protected $_belongs_to = array(
			'category' => array(),
			'author'     => array(
					'model' => 'User',
					'foreign_key' => 'user_id'
				)
		);

	protected $_has_many = array(
			'comments' => array()
		);

	protected $_load_with = array(
			'category',
			'author'
		);

}