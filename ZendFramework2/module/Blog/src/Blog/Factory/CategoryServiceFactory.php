<?php

namespace Blog\Factory;

use Blog\Service\CategoryService;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CategoryServiceFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return CategoryService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ObjectManager $em */
        $em = $serviceLocator->get('orm_em');

        return new CategoryService($em);
    }
}
