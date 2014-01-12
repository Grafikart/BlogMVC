<?php

namespace Blog\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class PostForm extends BaseForm
{
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        parent::__construct('post-form');

        $this->add(array(
            'name'       => 'id',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));

        $this->add(array(
            'name'       => 'name',
            'type'       => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'PLACEHOLDER_NAME',
                'required'    => true,
            ),
            'options' => array(
                'label' => 'INPUT_NAME',
            ),
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'category',
            'options' => array(
                'label'          => 'SELECT_CATEGORY',
                'object_manager' => $entityManager,
                'target_class'   => 'Blog\Business\Entity\Category',
                'property'       => 'name',
            ),
            'attributes' => array(
                'class'    => 'form-control',
                'required' => true,
            )
        ));

        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
            'name'    => 'user',
            'options' => array(
                'label'          => 'SELECT_AUTHOR',
                'object_manager' => $entityManager,
                'target_class'   => 'Blog\Business\Entity\User',
                'property'       => 'username',
            ),
            'attributes' => array(
                'class'    => 'form-control',
                'required' => true,
            )
        ));

        $this->add(array(
            'name'       => 'slug',
            'type'       => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'PLACEHOLDER_SLUG',
            ),
            'options' => array(
                'label' => 'INPUT_SLUG',
            ),
        ));

        $this->add(array(
            'name'       => 'content',
            'type'       => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class'       => 'form-control',
                'placeholder' => 'PLACEHOLDER_POST',
                'rows'        => 6,
                'cols'        => 30,
                'required'    => true,
            ),
            'options' => array(
                'label' => 'INPUT_POST',
            ),
        ));

        $this->get('submit')->setAttribute('value', 'SUBMIT_POST');

        $this->setValidationGroup(array(
            'name',
            'category',
            'slug',
            'user',
            'content',
        ));
    }
}