<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Blog Controller Class
 *
 * The Controller in charge of displaying all the blog pages
 *
 * @class		Blog
 * @extends		CI_Controller
 * @category	Controller
 * @link		https://ellislab.com/codeigniter/user-guide/general/controllers.html
 */
class Blogadmin extends CI_Controller
{
	public function __construct() 
	{
		parent::__construct();

		if(ENVIRONMENT == 'development' || ENVIRONMENT == 'testing')
		{
			// configure profiler for common debugging while in development environnement (data appended to body)
			$this->output->enable_profiler(TRUE);
			$sections = array(
				// Elapsed time of Benchmark points and total execution time
				'benchmarks' => true,
				// CodeIgniter Config variables
				'config'  => true,
				// The Controller class and method requested
				'controller_info' => true,
				// Any GET data passed in the request
				'get' => true,
				// Any POST data passed in the request
				'post' => true,
				// The HTTP headers for the current request
				'http_headers' => true,
				// Amount of memory consumed by the current request, in bytes
				'memory_usage' => true,
				// The URI of the current request
				'uri_string' => true,
				// Listing of all database queries executed, including execution time
				'queries' => TRUE,
				// The number of queries after which the query block will default to hidden.
				'query_toggle_count' => 25
			);
			$this->output->set_profiler_sections($sections);
		}

		// loading some url helpers methods (base_url() especially, see system/helpers/url_helper.php)
		$this->load->helper('url');
		// initialize the php session and load the native CI's session object
		$this->load->driver('session');
		// load site-specific config directives
		$this->load->config('blog');

		if($this->session->userdata('admin') === NULL) 
		{
			redirect('/login');
			exit;
		}
		// loading CodeIgniter's default template engine (see system/librairies/CI_Parser.php)
		$this->load->library('parser');
		// connect to database (see configuration file in application/config/database.php)
		$this->load->database();
	}

	public function index()
	{
		// loading application/models/Posts_model.php Class (now accessible via $this->posts_model)
		$this->load->model('posts_model');

		// get parameter 'page' from request
		$page = (int) $this->input->get('page');

		// load blog entries from db
		$blog_entries = $this->posts_model->paginate($page?$page:1);

		$posts_cnt = $this->db->count_all('posts');

		// load custom MY_Pagination Class inherited from CodeIgniter's pagination Class (see application/librairies/MY_Pagination)
		// Access via $this->pagination->*
		$this->load->library('pagination',array('total_rows' => $posts_cnt, 'base_url' => base_url('admin')));
		$this->parser->parse('admin_index', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_admin'   	=> base_url('admin'),
			'url_logout'   	=> base_url('admin/logout'),
			'pagination'	=> $this->pagination->create_links(),
			'blog_entries'	=> $blog_entries
		));
	}

	public function post($post_id = 0) 
	{
		$post_datas = array(
			'name' => '',
			'slug' => '',
			'content' => '',
			'category_id' => 0,
			'user_id' => 0
		);

		// load custom form validation library from CodeIgniter
		// we need to load the library here to handle reuse of submitted values
		// see https://ellislab.com/codeigniter/user-guide/libraries/form_validation.html
		$this->load->library('form_validation');

		// Admin wants to edit post, load post datas
		if($post_id && !count($this->input->post())) 
		{
			$post_datas = $this->db->get_where('posts',array('id' => $post_id))->row_array();
		}

		// Form submitted ?
		if($this->input->post()) 
		{
			// Load form datas 
			$post_form = $this->input->post('data[Post]');
			$post_datas = array_merge($post_datas,$post_form);

			$this->form_validation
				->set_rules('data[Post][name]','Nom','trim|required')
				->set_rules('data[Post][content]','Contenu','trim|required')
				->set_rules('data[Post][slug]','slug','trim|required');

			if($this->form_validation->run())
			{
				$post_datas['created'] = date('Y-m-d H:i:s');

				// Edit post ?
				if($post_id) {
					$this->db->where('id',$post_id)->update('posts',$post_datas);
				}
				// Add post
				else {
					$this->db->insert('posts',$post_datas);
				}
				redirect('/admin');
			}
		}

		$categories = $this->db->get('categories')->result_array();
		foreach ($categories as &$category) {
			$category['selected'] = $category['id'] == $post_datas['category_id'] ? 'selected':'';
		}

		$users = $this->db->get('users')->result_array();
		foreach ($users as &$user) {
			$user['selected'] = $user['id'] == $post_datas['user_id'] ? 'selected':'';
		}

		$this->parser->parse('admin_edit', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_admin'   	=> base_url('admin'),
			'url_logout'   	=> base_url('admin/logout'),
			'form_action'	=> $post_id ? base_url('admin/post/'.$post_id) : base_url('admin/post/'),
			'label_action'	=> $post_id ? 'Editer' : 'Ajouter',
			'post_name'		=> $post_datas['name'],
			'post_slug'		=> $post_datas['slug'],
			'post_content'	=> $post_datas['content'],
			'categories'	=> $categories,
			'authors'		=> $users
		));
	}

	public function delete($post_id=0) 
	{
		$this->db->delete('posts',array('id' => $post_id));
		$this->db->delete('comments',array('post_id' => $post_id));
		redirect('/admin');
	}

	public function logout() 
	{
		$this->session->sess_destroy();
		redirect('/login');
		exit;
	}
}
?>