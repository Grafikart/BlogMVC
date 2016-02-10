<?php

namespace Blog\Factory;

use Blog\Listener\DispatchListener;
use Blog\Service\CacheService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DispatchListenerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return DispatchListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var CacheService $categoryService */
        $cacheFactory = $serviceLocator->get('Blog\Service\Cache');
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');

        return new DispatchListener($cacheFactory, $authenticationService);
    }
}
