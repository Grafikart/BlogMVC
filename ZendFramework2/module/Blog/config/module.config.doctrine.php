<?php
return array(
    'eventmanager' => array(
        'orm_default' => array(
            'subscribers' => array(
                'Gedmo\Sluggable\SluggableListener',
            ),
        ),
    ),
    'driver' => array(
        'blog_driver' => array(
            'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(
                'module/Blog/src/Blog/Entity'
            )
        ),
        'orm_default' => array(
            'drivers' => array(
                'Blog\Entity' => 'blog_driver',
            ),
        ),
    ),
    'authentication' => array(
        'orm_default' => array(
            //should be the key you use to get doctrine's entity manager out of zf2's service locator
            'objectManager' => 'Doctrine\ORM\EntityManager',
            //fully qualified name of your user class
            'identityClass' => 'Blog\Entity\User',
            //the identity property of your class
            'identityProperty' => 'username',
            //the password property of your class
            'credentialProperty' => 'password',
            //a callable function to hash the password with
            'credentialCallable' => 'Blog\Entity\User::hashPassword'
        ),
    ),
);