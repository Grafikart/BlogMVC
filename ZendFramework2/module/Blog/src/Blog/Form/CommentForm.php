<?php

namespace Blog\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class CommentForm extends Form
{
    public function init()
    {

        $this->add(
            array(
                'name' => 'comment',
                'type' => 'Blog\Form\Fieldset\CommentFieldset',
                'options' => array(
                    'use_as_base_fieldset' => true,
                ),
            )
        );

        // csrf element
        $this->add(
            array(
                'type' => 'Zend\Form\Element\Csrf',
                'name' => 'csrf_comment',
            )
        );

        $this->setValidationGroup(
            array(
                'comment' => array(
                    'mail',
                    'username',
                    'content',
                ),
                'csrf_comment',
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'SUBMIT_COMMENT',
                    'class' => 'btn btn-primary'
                )
            )
        );
    }
}
