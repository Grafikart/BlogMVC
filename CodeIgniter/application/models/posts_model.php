<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model
{	
	public function __construct() 
	{
		parent::__construct();
	}
	
	protected function _format_article($articles=array()) 
	{
		// loading date_helper.php, comes along with helpful methods like mysql_to_unix(), etc...
		// also load custom file blog_helper (see application/helpers/blog_helper.php)
		get_instance()->load->helper(array('date','blog'));

		foreach ($articles as $key => &$row) 
		{
			$row['post_url'] 		= base_url($row['slug']);
			$row['category_url'] 	= base_url('category/'.$row['category_id']);
			$row['author_url'] 		= base_url('author/'.$row['user_id']);
			// mysql_to_unix() and mdate() methods comes with $this->load->helper('date') (call in Blog controller)
			$row['post_date'] 		= mdate("%M %dth %Y", mysql_to_unix($row['created']));
			$row['post_preview'] 	= blog_post_resume($row['content'], get_instance()->config->item('post_resume_length','blog'));

		}
		return $articles; 
	}

	public function slug($slug='') 
	{
		return $this->_format_article($this->db
			->join('users u','u.id=p.user_id')
			->join('categories c','c.id=p.category_id')
			->select('p.*,c.name category, u.username author')
			->where('p.slug',$slug)
			->limit(1)
			->get('posts p')
			->result_array()
		);
	}

	public function paginate($pagenum=1,$filters=array()) 
	{
		// Gets the $config['blog']['pagination_cnt'] value in the application/config/config.php file
		$pagination_cnt = get_instance()->config->item('pagination_cnt','blog');
		$from = ($pagenum-1)*$pagination_cnt;

		$this->db
			->select('p.*,c.name category, u.username author')
			->join('users u','u.id=p.user_id')
			->join('categories c','c.id=p.category_id')
			->order_by('p.created DESC')
			->limit($pagination_cnt,$from);

		if(array_key_exists('category_slug', $filters))
			$this->db->where('c.slug',$filters['category_slug']);

		return $this->_format_article($this->db->get('posts p',$pagination_cnt,$from)->result_array());
	}

	public function post_comments($post_id=0)
	{
		// load date_helper from CI's app singleton
		get_instance()->load->helper('date');

		$comments = $this->db
			->where('post_id',(int)$post_id)
			->order_by('created DESC')
			->get('comments')
			->result_array();

		return array_map(function($a)
		{
			$a['time_ago'] = timespan(mysql_to_unix($a['created']),time(),2);
			return $a;
		},$comments);
	}

	public function count_all_category($category_slug) 
	{
		return $this->db
			->join('categories c','p.category_id = c.id')
			->where('c.slug',$category_slug)
			->count_all_results('posts p');
	}
}
?>