<?php defined('SYSPATH') or die('No direct script access.');

class Model_Comment extends ORM{

	protected $_belongs_to = array(
			'post' => array()
		);

	public function rules(){
		return array(
			'username' => array(
				array('not_empty')
				),
			'mail' => array(
				array('not_empty'),
				array('email')
				),
			'content' => array(
				array('not_empty')
				)
			);
	}

}