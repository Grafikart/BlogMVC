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

	public function action($action) 
	{
		switch ($action) 
		{
			case 'login':
				// load custom form validation library from CodeIgniter (will be used in action_post_comment() method)
				// we need to load the library here for display purpose in the template (set_value() function)
				// see https://ellislab.com/codeigniter/user-guide/libraries/form_validation.html
				$this->load->library('form_validation');

				// user wants to submit a comment
				if($this->input->post('post_admin_login') !== NULL) 
				{
					$this->form_validation->set_rules('username', 'Login', 'trim|required|xss_clean');
					$this->form_validation->set_rules('password', 'Mot de passe', 'trim|required|md5');

					// if all validations are ok, insert the comment entry
					if($this->form_validation->run())
					{
						$this->load->model('users_model');
						$user = $this->users_model->get_user($this->input->post('username'),$this->input->post('password'));

						if($user) {
							redirect('/admin');
							exit;
						}
					}
				}
				redirect('/login');
			break;
			
			default:
				# code...
				break;
		}
	}

	public function index()
	{
		$blog_entries = $this->db->get('posts')->result();

		$this->parser->parse('admin_index', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_logout'   	=> base_url('admin/logout'),
			// 'blog_entries'	=> $blog_entries
		));
	}

	public function logout() 
	{
		$this->session->sess_destroy();
		redirect('/login');
		exit;
	}
}
?>