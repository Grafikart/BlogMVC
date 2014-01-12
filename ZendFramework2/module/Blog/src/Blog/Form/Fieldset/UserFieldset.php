<?php

namespace Blog\Form\Fieldset;

use DoctrineModule\Persistence\ProvidesObjectManager;
use Blog\Entity\User;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class UserFieldset extends Fieldset implements
    ObjectManagerAwareInterface,
    InputFilterProviderInterface
{
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager(), 'Blog\Entity\User'))
            ->setObject(new User());

        // Id
        $this->add(
            array(
                'type' => 'Zend\Form\Element\Hidden',
                'name' => 'id'
            )
        );

        // Login
        $this->add(
            array(
                'name' => 'username',
                'type' => 'Zend\Form\Element\Text',
                'attributes' => array(
                    'class'       => 'form-control',
                    'placeholder' => 'PLACEHOLDER_USERNAME',
                    'required'    => 'required',
                ),
                'options' => array(
                    'label' => 'INPUT_USERNAME',
                ),
            )
        );

        // Password
        $this->add(
            array(
                'name' => 'password',
                'type' => 'Zend\Form\Element\Password',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'PLACEHOLDER_PASSWORD',
                    'required' => 'required',
                ),
                'options' => array(
                    'label' => 'INPUT_PASSWORD',
                ),
            )
        );
    }

    /**
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'usermane' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 2,
                            'max' => 40,
                        ),
                    ),
                ),
            ),
            'password' => array(
                'required' => true,
            ),
        );
    }
}
