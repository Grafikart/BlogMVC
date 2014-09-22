<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		// loading CodeIgniter's default template engine (see system/librairies/CI_Parser.php)
		$this->load->library('parser');
		// loading some url helpers methods (base_url() especially, see system/helpers/url_helper.php)
		$this->load->helper('url');
		// connect to database (see configuration file in application/config/database.php)
		$this->load->database();
	}

	public function index()
	{
		// loading date_helper.php, comes along with helpful methods like mysql_to_unix(), etc...
		$this->load->helper('date');
		// loading application/models/Posts_model.php Class (now accessible via $this->posts_model)
		$this->load->model('posts_model');
		$blog_entries = $this->posts_model->all();

		$this->parser->parse('blog_index', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_admin'   	=> base_url('admin'),
			'blog_entries'	=> $blog_entries
		));
	}

	public function article($slug='') 
	{
		if(empty($slug))
			show_404();

		// loading date_helper.php, comes along with helpful methods like mysql_to_unix(), etc...
		$this->load->helper('date');
		// loading application/models/Posts_model.php Class (now accessible via $this->posts_model)
		$this->load->model('posts_model');
		$article = $this->posts_model->slug((string) $slug);

		if(!$article)
			show_404();

		$this->parser->parse('blog_post', array(
			'host'   		=> $_SERVER['HTTP_HOST'],
			'url_root'   	=> base_url(),
			'url_admin'   	=> base_url('admin'),
			'article'	=> $article
		));
	}
}
?>