<?php defined('SYSPATH') or die('No direct script access.');

// Je crée une fonction permettant de vérifier que la requête est bien une requête POST
$postRequest = function($route, $params, $request)
{
	if ($request->method() !== HTTP_Request::POST)
        {
            return FALSE; // This route only matches POST requests
        }
};

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

//page d'accueil
Route::set('default', '')
	->defaults(array(
		'controller' => 'posts',
		'action'     => 'index',
	));


//Les catégories
Route::set('category', 'category/<category>', 
	array( 'category' => '[0-9a-z\-]+' ))
	->defaults(array(
		'controller' => 'posts',
		'action' => 'category'
	));

//Le profil des utilisateurs
Route::set('user', 'author/<user>', 
	array( 'user' => '[0-9\-]+' ))
	->defaults(array(
		'controller' => 'posts',
		'action' => 'author'
	));

//Voir un post
Route::set('slug', 'post/<slug>', 
	array( 'slug' => '[0-9a-z\-]+' ))
	->defaults(array(
		'controller' => 'posts',
		'action' => 'show'
	));

Route::set('comment','comment/<post_slug>' , 
	array( 'post_slug' => '[0-9a-z\-]+' ))
	->filter($postRequest)
	->defaults(array(
			'controller' => 'comment',
			'action' => 'create_comment'
		));

Route::set('post_login', 'login')
	->filter($postRequest)
	->defaults(array(
			'controller' => 'admin',
			'action' => 'post_login'
		));

//Si ce n'est pas une action POST
Route::set('get_login', 'login')
	->defaults(array(
			'controller' => 'admin',
			'action' => 'get_login'
		));

// Route pour l'admin
Route::set('admin' , 'admin')
	->defaults(array(
			'controller' => 'admin',
			'action' => 'index'
		));

Route::set('admin_edit' , 'admin/<action>(/<post_slug>)',
	array('action' => '(create|edit|delete)'))
	->filter(function($route, $params, $request){
		//permet de faire un controlleur de type REST
		if($request->method() == HTTP_Request::POST){
			$params['action'] = 'post_' . $params['action'];
		} else {
			$params['action'] = 'get_' . $params['action'];
		}
		return $params;

	})
	->defaults(array(
			'controller' => 'admin'
		));
