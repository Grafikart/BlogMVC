<?php

namespace Blog\Factory;

use Blog\View\Helper\MessengerWidget;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\FlashMessenger;

class MessengerWidgetFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var FlashMessenger $flashMessenger */
        $flashMessenger = $serviceLocator->get('flashMessenger');
        $viewHelper = new MessengerWidget($flashMessenger);

        return $viewHelper;
    }
}
