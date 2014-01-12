<?php

namespace Blog\Form\Fieldset;

use Blog\Entity\Comment;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class CommentFieldset extends Fieldset implements
    ObjectManagerAwareInterface,
    InputFilterProviderInterface
{
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager(), 'Blog\Entity\Comment'))
            ->setObject(new Comment());

        // Id
        $this->add(
            array(
                'type' => 'Zend\Form\Element\Hidden',
                'name' => 'id'
            )
        );

        $this->add(
            array(
                'name' => 'mail',
                'type' => 'Zend\Form\Element\Email',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'PLACEHOLDER_MAIL',
                    'required' => true,
                ),
                'options' => array(
                    'label' => 'INPUT_MAIL',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'username',
                'type' => 'Zend\Form\Element\Text',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'PLACEHOLDER_USERNAME',
                    'id' => 'exampleInputEmail1',
                    'required' => true,
                ),
                'options' => array(
                    'label' => 'INPUT_USERNAME',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'content',
                'type' => 'Zend\Form\Element\Textarea',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'PLACEHOLDER_COMMENT',
                    'rows' => 3,
                    'required' => true,
                ),
                'options' => array(
                    'label' => 'INPUT_COMMENT',
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
            'mail' => array(
                'required' => true,
            ),
            'username' => array(
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
                            'min' => 3,
                        ),
                    ),
                ),
            ),
        );
    }
}
