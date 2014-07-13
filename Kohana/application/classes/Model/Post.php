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

	public function rules(){
		return array(
			'category_id' => array(
				array('digit')
				),
			'user_id' => array(
				array('digit')
				),
			'name' => array(
				array('not_empty')
				),
			'slug' => array(
				array('regex' , array(':value' , '([0-9a-z\-]+)'))
				),
			'content' => array(
				array('not_empty')
				)
			);
	}

}