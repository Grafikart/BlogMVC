<?php

$router->addRoute('home',
    new Zend_Controller_Router_Route(
        '/:page',
        ['controller' => 'posts', 'action' => 'index', 'page' => 1]
    )
);

$routes = [

    'admin' => [
        'url'        => 'admin',
        'controller' => 'admin', 'action' => 'index'
    ],

    'view_post'    => [
        'url'        => 'posts/:slug',
        'controller' => 'posts', 'action' => 'show'
    ],
    'new_post'     => [
        'url'        => 'admin/posts/new',
        'controller' => 'posts', 'action' => 'new'
    ],
    'edit_post'    => [
        'url'        => 'admin/posts/:id/edit',
        'controller' => 'posts', 'action' => 'edit'
    ],
    'delete_post'  => [
        'url'        => 'admin/posts/:id/delete',
        'controller' => 'posts', 'action' => 'delete'
    ],
    'comment_post' => [
        'url'        => 'posts/:id/comment',
        'controller' => 'comments', 'action' => 'create'
    ],

    'view_category'   => [
        'url'        => 'categories/:slug',
        'controller' => 'categories', 'action' => 'show'
    ],
    'new_category'    => [
        'url'        => 'admin/categories/new',
        'controller' => 'categories', 'action' => 'new'
    ],
    'edit_category'   => [
        'url'        => 'admin/categories/:id/edit',
        'controller' => 'categories', 'action' => 'edit'
    ],
    'delete_category' => [
        'url'        => 'admin/categroy/:id/delete',
        'controller' => 'categories', 'action' => 'delete'
    ],

    'view_user' => [
        'url'        => 'users/:id',
        'controller' => 'users', 'action' => 'show'
    ],
];

foreach ($routes as $name => $data) {
    $router->addRoute($name,
        new Zend_Controller_Router_Route(
            $data['url'],
            ['controller' => $data['controller'], 'action' => $data['action']]
        )
    );
}
