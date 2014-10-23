<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination 
{
	public function __construct($custom_params = array()) 
	{
		parent::__construct();

		$this->CI->load->helper('url');
		$params = $this->CI->config->item('pagination_datas','blog');
		$this->initialize(array_merge($params,$custom_params));
	}
}

/* End of file BlogPagination.php */
/* Location: ./application/libraries/MY_Pagination.php */