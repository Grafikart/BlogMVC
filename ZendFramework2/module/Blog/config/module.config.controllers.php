<?php
return array(
    'invokables' => array(

    ),
    'factories' => array(
        'Blog\Controller\Connexion' => 'Blog\Factory\ConnexionControllerFactory',
        'Blog\Controller\Post'      => 'Blog\Factory\PostControllerFactory',
    )
);