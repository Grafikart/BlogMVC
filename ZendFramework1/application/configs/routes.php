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
		'posts/:id',
		array('controller' => 'posts', 'action' => 'show')
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