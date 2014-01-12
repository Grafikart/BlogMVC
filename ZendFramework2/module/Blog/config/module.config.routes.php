<?php
return array(
    'routes' => array(
        'home' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route'    => '/',
                'defaults' => array(
                    'controller' => 'Blog\Controller\Post',
                    'action'     => 'index',
                ),
            ),
        ),
        'admin' => array(
            'type'    => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route'    => '/admin',
                'defaults' => array(
                    'controller' => 'Blog\Controller\Connexion',
                    'action'     => 'index',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'logout' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Literal',
                    'options' => array(
                        'route'    => '/logout',
                        'defaults' => array(
                            'action' => 'logout',
                        ),
                    ),
                ),
                'posts' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Literal',
                    'options' => array(
                        'route'    => '/posts',
                        'defaults' => array(
                            'controller'    => 'Blog\Controller\Post',
                            'action'        => 'indexAdmin',
                        ),
                    ),
                    'may_terminate' => true,
                    'child_routes' => array(
                        'list' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '[/page/:page]',
                                'defaults' => array(
                                    'page' => 1,
                                ),
                                'constraints' => array(
                                    'page' => '[0-9]+',
                                ),
                            ),
                        ),
                        'delete' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/delete/:id',
                                'defaults' => array(
                                    'action' => 'delete',
                                ),
                                'constraints' => array(
                                    'id' => '[0-9]+',
                                ),
                            ),
                        ),
                        'edit' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/edit/:id',
                                'defaults' => array(
                                    'action' => 'edit',
                                ),
                                'constraints' => array(
                                    'id' => '[0-9]+',
                                ),
                            ),
                        ),
                        'add' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/add',
                                'defaults' => array(
                                    'action' => 'add',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'posts' => array(
            'type'    => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route'    => '/posts',
                'defaults' => array(
                    'controller'    => 'Blog\Controller\Post',
                    'action'        => 'index',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'list' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route'    => '[/page/:page][/category/:category][/author/:author]',
                        'defaults' => array(
                            'page' => 1,
                        ),
                        'constraints' => array(
                            'page'     => '[0-9]+',
                            'category' => '[a-zA-Z\-0-9]+',
                            'author'   => '[0-9]+',
                        ),
                    ),
                ),
                'show' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route'    => '/:slug',
                        'defaults' => array(
                            'action' => 'show',
                        ),
                        'constraints' => array(
                            'slug' => '[a-zA-Z\-0-9]+',
                        ),
                    ),
                ),
                'category' => array(
                    'type'    => 'segment',
                    'options' => array(
                        'route'    => 'category/:slug',
                        'defaults' => array(
                            'action' => 'category',
                        ),
                        'constraints' => array(
                            'slug' => '[a-zA-Z\-0-9]+',
                        ),
                    ),
                ),
            ),
        ),
    ),
);