<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model
{	
	public function __construct() 
	{
		parent::__construct();
	}
	
	protected function _format_article($articles=array()) 
	{
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

	public function paginate($pagenum=1) 
	{
		// Gets the $config['blog']['pagination_cnt'] value in the application/config/config.php file
		$pagination_cnt = get_instance()->config->item('pagination_cnt','blog');
		$from = ($pagenum-1)*$pagination_cnt;

		return $this->_format_article($this->db
			->select('p.*,c.name category, u.username author')
			->join('users u','u.id=p.user_id')
			->join('categories c','c.id=p.category_id')
			->order_by('p.created DESC')
			->limit($pagination_cnt,$from)
			->get('posts p',$pagination_cnt,$from)
			->result_array()
		);
	} 
}
?>