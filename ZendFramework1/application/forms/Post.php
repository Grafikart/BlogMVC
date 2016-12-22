<?php

class Application_Form_Post extends Zend_Form
{

	public function init()
	{
		$this->setMethod('post');

		$this->addElement('hidden', 'id');

		$this->addElement('text', 'name', array(
				'label'	=> 'Name of this post',
				'required' => true,
				'filters' => array('StringTrim'),
				'class' => 'form-control'
			)
		);

		$this->addElement('textarea', 'content', array(
				'label'	=> 'Content of your post',
				'required' => true,
				'filters' => array('StringTrim'),
				'class' => 'form-control'
			)
		);

		$this->addElement('text', 'categoryId', array(
				'label'	=> 'Id of the category',
				'required' => true,
				'filters' => array('Int'),
				'class' => 'form-control'
			)
		);

		$this->addElement('text', 'userId', array(
				'label'	=> 'Id of the creator',
				'required' => true,
				'filters' => array('Int'),
				'class' => 'form-control'
			)
		);


		$this->addElement('submit', 'submit', array(
				'ignore' => true,
				'label' => 'create this post',
				'class' => 'form-control'
			)
		);

	}


}

