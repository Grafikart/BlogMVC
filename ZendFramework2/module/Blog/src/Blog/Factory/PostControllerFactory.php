<?php

namespace Blog\Factory;

use Blog\Controller\PostController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostControllerFactory implements FactoryInterface
{

    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return PostController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PostController();
    }
}