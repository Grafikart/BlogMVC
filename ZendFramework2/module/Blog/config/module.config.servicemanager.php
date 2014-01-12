<?php
return array(
    'abstract_factories' => array(
        'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        'Zend\Log\LoggerAbstractServiceFactory',
    ),
    'aliases' => array(
        'translator' => 'MvcTranslator',
        'orm_em'     => 'Doctrine\ORM\EntityManager',
        'Zend\Authentication\AuthenticationService' => 'doctrine.authenticationservice.orm_default',
    ),
    'factories' => array(

    ),
);