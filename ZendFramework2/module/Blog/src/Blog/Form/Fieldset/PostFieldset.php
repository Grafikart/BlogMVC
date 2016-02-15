<?php

namespace Blog\Form\Fieldset;

use Blog\Entity\Post;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class PostFieldset extends Fieldset implements
    ObjectManagerAwareInterface,
    InputFilterProviderInterface
{
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager(), 'Blog\Entity\Post'))
            ->setObject(new Post());

        $this->add(
            array(
                'name' => 'id',
                'attributes' => array(
                    'type' => 'hidden'
                )
            )
        );

        $this->add(
            array(
                'name' => 'name',
                'type' => 'Zend\Form\Element\Text',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'PLACEHOLDER_NAME',
                    'required' => true,
                ),
                'options' => array(
                    'label' => 'INPUT_NAME',
                ),
            )
        );

        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'category',
                'options' => array(
                    'label' => 'SELECT_CATEGORY',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Blog\Entity\Category',
                    'property' => 'name',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => true,
                )
            )
        );

        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'user',
                'options' => array(
                    'label' => 'SELECT_AUTHOR',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Blog\Entity\User',
                    'property' => 'username',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'required' => true,
                )
            )
        );

        $this->add(
            array(
                'name' => 'content',
                'type' => 'Zend\Form\Element\Textarea',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'PLACEHOLDER_POST',
                    'rows' => 6,
                    'cols' => 30,
                    'required' => true,
                ),
                'options' => array(
                    'label' => 'INPUT_POST',
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
            'name' => array(
                'required' => true,
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
            'category' => array(
                'required' => true,
            ),
            'user' => array(
                'required' => true,
            ),
            'content' => array(
                'required' => true,
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
                        ),
                    ),
                ),
            ),
        );
    }
}
