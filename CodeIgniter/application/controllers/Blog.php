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
class Blog extends CI_Controller
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

		// loading CodeIgniter's default template engine (see system/librairies/CI_Parser.php)
		$this->load->library('parser');
		// load site-specific config directives
		$this->load->config('blog');
		// loading some url helpers methods (base_url() especially, see system/helpers/url_helper.php)
		$this->load->helper('url');
		// connect to database (see configuration file in application/config/database.php)
		$this->load->database();
	}

	protected function _load_categories() 
	{
		$categories = $this->db->get('categories')->result_array();
		return array_map(function($a) {
			$a['category_url'] = base_url('category/'.$a['slug']);
			return $a;
		}, $categories);
	}

	public function index()
	{
		// loading application/models/Posts_model.php Class (now accessible via $this->posts_model)
		$this->load->model('posts_model');

		// load CodeIgniter's pagination Class (see system/librairies/Pagination)
		// Access via $this->pagination->*
		$this->load->library('pagination');
		
		// get parameter 'page' from request
		$page = (int) $this->input->get('page');

		// load blog entries from db
		$blog_entries = $this->posts_model->paginate($page?$page:1);
		$posts_cnt = $this->db->count_all('posts');

		// pagination class parameters
		$pagination = array(
			'base_url' 			=> base_url(),
			'total_rows' 		=> $posts_cnt,
			'per_page' 			=> $this->config->item('pagination_cnt','blog'),
			'num_links'	 		=> 4,
			'use_page_numbers' 	=> TRUE,
			'query_string_segment' => 'page',
			'page_query_string' => TRUE,
			'first_link' 		=> '<<',
			'last_link' 		=> '>>',
			'next_link'		 	=> '>',
			'prev_link' 		=> '<',
			'full_tag_open' 	=> '<li>',
			'full_tag_close' 	=> '</li>',
			'cur_tag_open' 		=> '<a>',
			'cur_tag_close' 	=> '</a>'
		);
		$this->pagination->initialize($pagination);

		// set variables to CodeIgniter's template parser
		$this->parser->parse('blog_index', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_admin'   	=> base_url('admin'),
			'blog_entries'	=> $blog_entries,
			'pagination'	=> $this->pagination->create_links(),
			'categories'	=> $this->_load_categories()
		));
	}

	public function article($slug='')
	{
		// If no slug was specified, redirect to the HTTP 404 error
		if(empty($slug))
			show_404();

		// loading date_helper.php, comes along with helpful methods like mysql_to_unix(), etc...
		$this->load->helper('date');

		// loading application/models/Posts_model.php Class (now accessible via $this->posts_model)
		$this->load->model('posts_model');

		// fetch article data
		$article = $this->posts_model->slug((string) $slug);

		// if no article found, redirect to 404 error
		if(!$article)
			show_404();

		// load custom form validation library from CodeIgniter (will be used in action_post_comment() method)
		// we need to load the library here for display purpose in the template (set_value() function)
		// see https://ellislab.com/codeigniter/user-guide/libraries/form_validation.html
		$this->load->library('form_validation');

		$valid_form = true;

		// user wants to submit a comment
		if($this->input->post('post_comment') !== NULL) 
		{
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('body', 'Commentaire', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');

			// if all validations are ok, insert the comment entry
			if($valid_form = $this->form_validation->run())
			{
				// Note: All values are escaped automatically producing safer queries.
				// set https://ellislab.com/codeigniter/user-guide/database/active_record.html
				$this->db->insert('comments',array(
					'post_id' 	=> $this->input->post('post_id'),
					'username' 	=> $this->input->post('username'),
					'content' 	=> $this->input->post('body',TRUE), // XSS filter
					'mail' 		=> $this->input->post('email'),
					'created' 	=> date("Y-m-d H:i:s")
				));

				$this->form_validation->reset_validation();
			}
		}

		// MARKDOWN PLUG IN (from michelf/php-markdown)
		// Installed via composer (see composer.json require : "michelf/php-markdown": "1.4.*")
		// Proper way to load markdown plugin : load custom library Class hosting the plug-in feature (see application/librairies/Markdown.php)
		$this->load->library('markdown');
		$article[0]['content'] = $this->markdown->apply($article[0]['content']);

		// article comments
		$comments = $this->posts_model->post_comments($article[0]['id']);

		// Comments
		$this->parser->parse('blog_post', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_admin'   	=> base_url('admin'),
			'post_comment_action' => current_url(),
			'article'		=> $article,
			'post_id'		=> $article[0]['id'],
			'categories'	=> $this->_load_categories(),
			'show_error_msg'=> $valid_form ? array() : array(array(true)), // trigger display of the overall error message ?
			'comments'		=> $comments,
			'comments_cnt'	=> count($comments),
			'email_has_error_class'		=> strlen($this->form_validation->error('email')) > 0 ? 'has-error' : '',
			'username_has_error_class'	=> strlen($this->form_validation->error('username')) > 0 ? 'has-error' : '',
			'body_has_error_class'		=> strlen($this->form_validation->error('body')) > 0 ? 'has-error' : ''
		));
	}

	public function category($category_slug) 
	{
		// loading application/models/Posts_model.php Class (now accessible via $this->posts_model)
		$this->load->model('posts_model');

		// load CodeIgniter's pagination Class (see system/librairies/Pagination)
		// Access via $this->pagination->*
		$this->load->library('pagination');
		
		// get parameter 'page' from request
		$page = (int) $this->input->get('page');

		// load blog entries from db
		$blog_entries = $this->posts_model->paginate($page?$page:1,array('category_slug' => $category_slug));
		$posts_cnt = $this->posts_model->count_all_category($category_slug);

		// pagination class parameters
		$pagination = array(
			'base_url' 			=> base_url(),
			'total_rows' 		=> $posts_cnt,
			'per_page' 			=> $this->config->item('pagination_cnt','blog'),
			'num_links'	 		=> 4,
			'use_page_numbers' 	=> TRUE,
			'query_string_segment' => 'page',
			'page_query_string' => TRUE,
			'first_link' 		=> '<<',
			'last_link' 		=> '>>',
			'next_link'		 	=> '>',
			'prev_link' 		=> '<',
			'full_tag_open' 	=> '<li>',
			'full_tag_close' 	=> '</li>',
			'cur_tag_open' 		=> '<a>',
			'cur_tag_close' 	=> '</a>'
		);
		$this->pagination->initialize($pagination);

		// set variables to CodeIgniter's template parser
		$this->parser->parse('blog_index', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_admin'   	=> base_url('admin'),
			'blog_entries'	=> $blog_entries,
			'pagination'	=> $this->pagination->create_links(),
			'categories'	=> $this->_load_categories()
		));
	}
}
?>