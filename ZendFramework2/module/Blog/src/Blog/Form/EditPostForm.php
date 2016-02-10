<?php

namespace Blog\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class EditPostForm extends Form
{
    public function init()
    {
        $this->add(
            array(
                'name' => 'post',
                'type' => 'Blog\Form\Fieldset\PostFieldset',
                'options' => array(
                    'use_as_base_fieldset' => true,
                ),
            )
        );

        // csrf element
        $this->add(
            array(
                'type' => 'Zend\Form\Element\Csrf',
                'name' => 'csrf_post',
            )
        );

        $this->setValidationGroup(
            array(
                'post' => array(
                    'name',
                    'category',
                    'user',
                    'slug',
                    'content',
                ),
                'csrf_post',
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Edit',
                    'class' => 'btn btn-primary'
                )
            )
        );
    }
}
