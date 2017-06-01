<?php

class Application_Form_Admin extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'username', array(
                'label'    => 'username',
                'required' => true,
                'filters' => array('StringTrim'),
                'class' => 'form-control'
            )
        );

        $this->addElement('password', 'password', array(
                'label'    => 'password',
                'required' => true,
                'class' => 'form-control'
            )
        );

        $this->addElement('submit', 'submit', array(
                'ignore' => true,
                'label' => 'Sign in',
                'class' => 'btn btn-lg btn-primary btn-block'
            )
        );
    }
}
