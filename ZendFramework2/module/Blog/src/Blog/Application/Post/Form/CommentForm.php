<?php

namespace Blog\Application\Post\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

use Blog\Core\Form\BaseForm;

class CommentForm extends BaseForm
{
    public function __construct()
    {
        parent::__construct('comment-form');

        $this->add(array(
            'name'       => 'mail',
            'type'       => 'Zend\Form\Element\Email',
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'PLACEHOLDER_MAIL',
                'required'    => true,
            ),
            'options' => array(
                'label' => 'INPUT_MAIL',
            ),
        ));

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
            'name'       => 'content',
            'type'       => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'PLACEHOLDER_COMMENT',
                'rows'        => 3,
                'required'    => true,
            ),
            'options' => array(
                'label' => 'INPUT_COMMENT',
            ),
        ));

        $this->get('submit')->setAttribute('value', 'SUBMIT_COMMENT');
    }
}