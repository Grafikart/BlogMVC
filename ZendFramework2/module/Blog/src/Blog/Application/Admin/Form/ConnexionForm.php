<?php

namespace Blog\Application\Admin\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

use Blog\Core\Form\BaseForm;

class ConnexionForm extends BaseForm
{
    public function __construct()
    {
        parent::__construct('connexion-form');

        $this->add(array(
            'name'       => 'username',
            'type'       => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'PLACEHOLDER_USERNAME',
                'id'          => 'exampleInputEmail1',
                'required'    => true,
            ),
            'options' => array(
                'label' => 'INPUT_USERNAME',
            ),
        ));

        $this->add(array(
            'name'       => 'password',
            'type'       => 'Zend\Form\Element\Password',
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'PLACEHOLDER_PASSWORD',
                'required'    => true,
            ),
            'options' => array(
                'label' => 'INPUT_PASSWORD',
            ),
        ));

        $this->get('submit')->setAttribute('value', 'SUBMIT_LOGIN')->setAttribute('class', 'btn btn-lg btn-primary btn-block');
        $this->setAttribute('class', 'form-signin');
    }
}