<?php

class Application_Form_Post extends Zend_Form
{

	public function init()
	{
		$this->setMethod('post');

		$this->addElement('text', 'name', array(
				'label'	=> 'Name of this post',
				'required' => true,
				'filters' => array('StringTrim')
			)
		);

		$this->addElement('textarea', 'content', array(
				'label'	=> 'Content of your post',
				'required' => true,
				'filters' => array('StringTrim')
			)
		);

		$this->addElement('text', 'categoryId', array(
				'label'	=> 'Id of the category',
				'required' => true,
				'filters' => array('Int')
			)
		);

		$this->addElement('text', 'userId', array(
				'label'	=> 'Id of the creator',
				'required' => true,
				'filters' => array('Int')
			)
		);


		$this->addElement('submit', 'submit', array(
				'ignore' => true,
				'label' => 'create this post'
			)
		);

	}


}

