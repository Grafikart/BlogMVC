<?php

namespace Blog\Factory;

use Blog\Service\CacheService;
use Blog\Service\PostService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostServiceFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return PostService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ObjectManager $em */
        $em = $serviceLocator->get('orm_em');
        /** @var CacheService $cacheService */
        $cacheService = $serviceLocator->get('Blog\Service\Cache');

        return new PostService($em, $cacheService);
    }
}
