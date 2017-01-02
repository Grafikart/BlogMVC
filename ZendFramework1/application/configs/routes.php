<?php

$router->addRoute('home', 
	new Zend_Controller_Router_Route(
		'/',
		array(
			'controller' => 'posts',
			'action'     => 'index'
		) 
	)
);

$router->addRoute('admin', 
	new Zend_Controller_Router_Route(
		'admin',
		array('controller' => 'admin', 'action' => 'index')
	)
);

$router->addRoute('view_post', 
	new Zend_Controller_Router_Route(
		'posts/:slug',
		array('controller' => 'posts', 'action' => 'show')
	)
);

$router->addRoute('comment_post', 
	new Zend_Controller_Router_Route(
		'posts/:id/comment',
		array('controller' => 'comments', 'action' => 'create')
	)
);

$router->addRoute('new_post', 
	new Zend_Controller_Router_Route(
		'admin/posts/new',
		array('controller' => 'posts', 'action' => 'new')
	)
);

$router->addRoute('edit_post', 
	new Zend_Controller_Router_Route(
		'admin/posts/:id/edit',
		array('controller' => 'posts', 'action' => 'edit')
	)
);

$router->addRoute('delete_post', 
	new Zend_Controller_Router_Route(
		'admin/posts/:id/delete',
		array('controller' => 'posts', 'action' => 'delete')
	)
);

$router->addRoute('new_category', 
	new Zend_Controller_Router_Route(
		'admin/categories/new',
		array('controller' => 'categories', 'action' => 'new')
	)
);

$router->addRoute('view_user', 
	new Zend_Controller_Router_Route(
		'users/:id',
		array('controller' => 'users', 'action' => 'show')
	)
);

$router->addRoute('view_category', 
	new Zend_Controller_Router_Route(
		'category/:id',
		array('controller' => 'categories', 'action' => 'show')
	)
);