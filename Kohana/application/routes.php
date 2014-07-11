<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

//page d'accueil
Route::set('default', '/')
	->defaults(array(
		'controller' => 'posts',
		'action'     => 'index',
	));

//Route pour l'admin
Route::set('admin', '/admin(/<action>)')
	->defaults(array(
		'controller' => 'admin',
		'action'     => 'index',
	));

//Les catégories
Route::set('category', '/category/<category>', 
	array( 'category' => '[0-9a-z\-]+' ))
	->defaults(array(
		'controller' => 'admin',
		'action' => 'category'
	));

//Le profil des utilisateurs
Route::set('user', '/author/<user>', 
	array( 'user' => '[0-9\-]+' ))
	->defaults(array(
		'controller' => 'user',
		'action' => 'show'
	));

//Voir un post
Route::set('slug', '/<slug>', 
	array( 'slug' => '[0-9a-z\-]+' ))
	->defaults(array(
		'controller' => 'posts',
		'action' => 'show'
	));