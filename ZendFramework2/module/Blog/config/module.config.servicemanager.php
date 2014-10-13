<?php
return array(
    'abstract_factories' => array(
        'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        'Zend\Log\LoggerAbstractServiceFactory',
    ),
    'aliases'            => array(
        'translator' => 'MvcTranslator',
        'orm_em'     => 'Doctrine\ORM\EntityManager',
    ),
    'factories'          => array(
        'Blog\Service\Post'                         => 'Blog\Factory\PostServiceFactory',
        'Blog\Service\Comment'                      => 'Blog\Factory\CommentServiceFactory',
        'Blog\Service\Cache'                        => 'Blog\Factory\CacheServiceFactory',
        'Blog\Service\Category'                     => 'Blog\Factory\CategoryServiceFactory',
        'Blog\Listener\Dispatch'                    => 'Blog\Factory\DispatchListenerFactory',
        'Zend\Authentication\AuthenticationService' => 'Blog\Factory\AuthenticationServiceFactory',
    ),
);