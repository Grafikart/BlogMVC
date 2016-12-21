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

$router->addRoute('edit_post', 
	new Zend_Controller_Router_Route(
		'admin/:id/edit',
		array('controller' => 'posts', 'action' => 'edit')
	)
);

$router->addRoute('delete_post', 
	new Zend_Controller_Router_Route(
		'admin/:id/delete',
		array('controller' => 'posts', 'action' => 'delete')
	)
);