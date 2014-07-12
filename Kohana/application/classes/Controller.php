<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Controller extends Kohana_Controller {

	public function before(){

		//J'ai préféré utiliser la fonction Kohana::cache plutôt que le module Cache
        if (Kohana::cache('sidebar_categories') == NULL){
            $sidebar_categories = ORM::factory('Category')
            	->order_by('post_count','DESC')
            	->find_all();
            Kohana::cache('sidebar_categories', $sidebar_categories->cached() , 60 * 60); // 60s * 60s = 1 heure
        }
        View::set_global('sidebar_categories', Kohana::cache('sidebar_categories'));

        if (Kohana::cache('sidebar_posts') == NULL){
            $sidebar_posts = ORM::factory('Post')
            	->order_by('created', 'DESC')
            	->order_by('id', 'DESC')
            	->limit(2)
            	->find_all();
            Kohana::cache('sidebar_posts', $sidebar_posts->cached() , 60 * 60); // 60s * 60s = 1 heure
        }
        View::set_global('sidebar_posts', Kohana::cache('sidebar_posts'));

	}

}
