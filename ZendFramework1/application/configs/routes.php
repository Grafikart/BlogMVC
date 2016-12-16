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
		array('controller' => 'posts', 'action' => 'admin')
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