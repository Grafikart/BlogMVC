<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template{

	public $template = 'layouts/blog';

	public function before(){
		if(!Auth::instance()->logged_in() 
			&& $this->request->action() != 'get_login'
			&& $this->request->action() != 'post_login'){
			$this->redirect('login');
		}

		parent::before();
	}

	protected function clear_cache(){
		Kohana::cache('sidebar_categories',array(),0);
		Kohana::cache('sidebar_posts', array() , 0);
	}

	public function action_get_login(){

		$this->template->title = 'Login';
		$this->template->content = View::factory('admin/login');

	}

	public function action_post_login()
	{
		if(Auth::instance()->login( $this->request->post('username') , $this->request->post('password') )){

			$this->redirect('admin');

		} else {
			Session::instance()->set('flash_error' , TRUE );
			$this->redirect('login');
		}
	}

	public function action_logout(){
		Auth::instance()->logout();
		$this->redirect('');
	}

	public function action_index(){
		$posts = ORM::factory('Post')
			->order_by('post.created' , 'DESC')
			->find_all();

		$paginator = Paginator::factory($posts);
		$paginator->set_item_count_per_page(5);
		$paginator->set_current_page_number(Arr::get($_GET , 'page' , 1));

		$this->template->title = 'Admin';
		$this->template->content = View::factory('admin/index')->set('posts' , $paginator);
	}

	public function action_get_create(){
		$data = array(
			'categories' => ORM::factory('Category')->order_by('name')->find_all()->as_array('id' , 'name'),
			'authors'    => ORM::factory('User')->order_by('username')->find_all()->as_array('id' , 'username')
			);

		$this->template->title = 'Add a new post';
		$this->template->content = View::factory('admin/create' , $data);
	}

	public function action_post_create(){
		$post = ORM::factory('Post');

		$post->values($this->request->post() , array('name' , 'slug' , 'category_id' , 'user_id' , 'content'));
		$post->created = DB::expr('NOW()');

		try{
			$post->save();

			//Change le post_count des catégories
			if(!$post->category->loaded())$post->category->find();
			$post->category->post_count++;
			$post->category->save();

			$this->clear_cache();
			$this->redirect('admin');
		} catch (ORM_Validation_Exception $e){
			Session::instance()->set('flash_errors' , array_keys($e->errors()));
			$this->redirect('admin/create');
		}
	}

	public function action_get_edit(){
		$slug = $this->request->param('post_slug');

		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		$data = array(
			'post'       => $post,
			'categories' => ORM::factory('Category')->order_by('name')->find_all()->as_array('id' , 'name'),
			'authors'    => ORM::factory('User')->order_by('username')->find_all()->as_array('id' , 'username')
			);

		$this->template->title = "Edit " . $post->name;
		$this->template->content = View::factory('admin/edit' , $data);
	}

	public function action_post_edit(){
		$slug = $this->request->param('post_slug');

		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		$post->values($this->request->post() , array('name' , 'slug' , 'category_id' , 'user_id' , 'content'));

		try{
			if($post->changed('category_id'))$old_category = $post->category_id;
			$post->save();

			//Change le post_count des catégories
			if(isset($old_category)){
				$old_category = ORM::factory('Category' , $old_category);
				$old_category->post_count--;
				$old_category->save();

				if(!$post->category->loaded())$post->category->find();
				$post->category->post_count++;
				$post->category->save();
			}

			$this->clear_cache();
			$this->redirect('admin');
		} catch (ORM_Validation_Exception $e){
			Session::instance()->set('flash_errors' , array_keys($e->errors()));
			$this->redirect('admin/edit/' . $slug);
		}
	}

	public function action_get_delete(){
		$slug = $this->request->param('post_slug');

		$post = ORM::factory('Post')
			->where('post.slug','=',$slug)
			->find();

		if(!$post->loaded()){
			throw HTTP_Exception::factory(404);
		}

		//Change le post_count des catégories
		if(!$post->category->loaded())$post->category->find();
		$post->category->post_count--;
		$post->category->save();

		 // Supprime les commentaires en premier, utilisation de DB car l'ORM n'a pas de fonction de suppression de masse
		DB::delete('comments')->where('comments.post_id' , '=' , $post->id)->execute();

		$post->delete();

		$this->redirect('admin');
	}

}