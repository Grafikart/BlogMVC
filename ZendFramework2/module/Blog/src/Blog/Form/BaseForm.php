<?php
/**
 * Blog
 */
namespace Blog\Form;

use Traversable;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Hydrator\ClassMethods;

abstract class BaseForm extends Form
{
    private $options = array(
        'method' => 'post'
    );

    public function __construct($name, $options = array())
    {
        parent::__construct($name);

        $options = ArrayUtils::merge($this->options, $options);

        $this->setName(strtolower($name));
        $this->setAttribute('method', (isset($options['method']) ? $options['method'] : 'post'));

        if (isset($options['enctype'])) {
            $this->setAttribute('enctype', $options['enctype']);
        }

        $this->setHydrator(new ClassMethods());
        $this->setInputFilter(new InputFilter());

        $this->addDefaultElements();
    }

    public function addDefaultElements()
    {
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        $this->add(array(
            'name'       => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'BTN_SUBMIT',
                'class' => 'btn btn-primary'
            )
        ));
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Form\Form::bind()
     */
    public function bind($object, $flags = FormInterface::VALUES_NORMALIZED)
    {
        if (null != $object->getId() && null != $this->get('submit')) {
            $this->get('submit')->setAttribute('value', 'BTN_UPDATE');
        }

        parent::bind($object, $flags);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Form\Form::setValidationGroup()
     */
    public function setFormValidationGroup($validationGroup)
    {
        parent::setValidationGroup(ArrayUtils::merge($validationGroup, array(
            'csrf'
        )));
    }
}
