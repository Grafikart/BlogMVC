<?php


$router->addRoute('home',
    new Zend_Controller_Router_Route(
        '/:page',
        array('controller' => 'posts', 'action' => 'index', 'page' => 1 )
    )
);


$routes = array(

    'admin' => array(
        'url' => 'admin',
        'controller' => 'admin', 'action' => 'index'
    ),

    'view_post' => array(
        'url' => 'posts/:slug',
        'controller' => 'posts', 'action' => 'show'
    ),
    'new_post' => array(
        'url' => 'admin/posts/new',
        'controller' => 'posts', 'action' => 'new'
    ),
    'edit_post' => array(
        'url' => 'admin/posts/:id/edit',
        'controller' => 'posts', 'action' => 'edit'
    ),
    'delete_post' => array(
        'url' => 'admin/posts/:id/delete',
        'controller' => 'posts', 'action' => 'delete'
    ),
    'comment_post' => array(
        'url' => 'posts/:id/comment',
        'controller' => 'comments', 'action' => 'create'
    ),


    'view_category' => array(
        'url' => 'categories/:slug',
        'controller' => 'categories', 'action' => 'show'
    ),
    'new_category' => array(
        'url' => 'admin/categories/new',
        'controller' => 'categories', 'action' => 'new'
    ),
    'edit_category' => array(
        'url' => 'admin/categories/:id/edit',
        'controller' => 'categories', 'action' => 'edit'
    ),
    'delete_category' => array(
        'url' => 'admin/categroy/:id/delete',
        'controller' => 'categories', 'action' => 'delete'
    ),

    

    'view_user' => array(
        'url' => 'users/:id',
        'controller' => 'users', 'action' => 'show'
    ),
);



foreach ($routes as $name => $data) {
    $router->addRoute($name,
        new Zend_Controller_Router_Route(
            $data['url'],
            array('controller' => $data['controller'], 'action' => $data['action'] )
        )
    );
}
