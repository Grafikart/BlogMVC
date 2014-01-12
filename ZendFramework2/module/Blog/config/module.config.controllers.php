<?php
return array(
    'invokables' => array(
        'Blog\Controller\Post'      => 'Blog\Controller\PostController',
    ),
    'factories' => array(
        'Blog\Controller\Connexion' => 'Blog\Factory\ConnexionControllerFactory',
    )
);