<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog;

return array(
    // Routes
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Blog\Application\Post',
                        'action'     => 'index',
                    ),
                ),
            ),
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller'    => 'Blog\Application\Connexion',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'posts' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/posts',
                            'defaults' => array(
                                'controller'    => 'Blog\Application\Post',
                                'action'        => 'indexAdmin',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'list' => array(
                                'type'    => 'segment',
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
                                'type'    => 'segment',
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
                        ),
                    ),
                ),
            ),
            'posts' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/posts',
                    'defaults' => array(
                        'controller'    => 'Blog\Application\Post',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'list' => array(
                        'type'    => 'segment',
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
                        'type'    => 'segment',
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
    ),

    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),

    'translator' => array(
        'locale' => 'en_EN',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Blog\Application\Post'      => 'Blog\Application\Post\Controller\PostController',
            'Blog\Application\Connexion' => 'Blog\Application\Admin\Controller\ConnexionController',
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'admin/layout'            => __DIR__ . '/../view/layout/admin.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . str_replace('\\', DIRECTORY_SEPARATOR, __NAMESPACE__) . '/Entity',
                    __DIR__ . '/../src/' . str_replace('\\', DIRECTORY_SEPARATOR, __NAMESPACE__) . '/Repository'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Business\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),

    // View Helper
    'view_helpers' => array(
        'invokables' => array(
            'Markdown'      => 'Blog\Core\Helper\View\Markdown',
            'Truncate'      => 'Blog\Core\Helper\View\Truncate',
            'Gravatar'      => 'Blog\Core\Helper\View\Gravatar',
            'TimeAgo'       => 'Blog\Core\Helper\View\TimeAgo',
        )
    ),
);
