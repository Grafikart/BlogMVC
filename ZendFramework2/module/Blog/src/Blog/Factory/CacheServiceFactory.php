<?php

namespace Blog\Factory;

use Blog\Service\CacheService;
use Blog\Service\CategoryService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CacheServiceFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return CacheService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ObjectManager $em */
        $em = $serviceLocator->get('orm_em');
        /** @var CategoryService $categoryService */
        $categoryService = $serviceLocator->get('Blog\Service\Category');

        return new CacheService($em, $categoryService);
    }
}
