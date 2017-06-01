<?php

class Application_Form_Category extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $this->addElement('hidden', 'id');
        
        $this->addElement('text', 'name', array(
                'label' => 'Name',
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
