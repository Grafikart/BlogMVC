<?php

class Application_Form_Comment extends Zend_Form
{

	public function init()
	{
		$this->setMethod('post');

		$this->addElement('hidden', 'id');
		$this->addElement('hidden', 'post_id');

		$this->addElement('text', 'mail', array(
				'label' => 'Email',
				'required' => true,
				'filters' => array('StringTrim'),
				'class' => 'form-control'
			)
		);

		$this->addElement('text', 'username', array(
				'label' => 'Username',
				'required' => true,
				'filters' => array('StringTrim'),
				'class' => 'form-control'
			)
		);

		$this->addElement('textarea', 'content', array(
				'label' => 'Content of your post',
				'required' => true,
				'filters' => array('StringTrim'),
				'class' => 'form-control'
			)
		);

		$this->addElement('submit', 'submit', array(
				'ignore' => true,
				'label' => 'Submit',
				'class' => 'btn btn-primary'
			)
		);

	}


}

