<?php


// Admin routes
Router::connect('/admin', array('controller' => 'posts', 'action' => 'index', 'admin' => true));

Router::connect('/', array('controller' => 'posts', 'action' => 'index'));
Router::connect('/category/:category', array('controller' => 'posts', 'action' => 'index'), array('category' => '[0-9a-z\-]+'));
Router::connect('/author/:user', array('controller' => 'posts', 'action' => 'index'), array('user' => '[0-9\-]+'));
Router::connect('/:slug', array('controller' => 'posts', 'action' => 'view'), array('pass' => array('slug'), 'slug' => '[0-9a-z\-]+'));

CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
