<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$config['blog'] = array(
	'pagination_cnt'		=> 5, 
	'post_resume_length' 	=> 500,
	'pagination_datas' 		=> array(
		'per_page' 			=> 5,
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
	) 
);

/* End of file blog.php */
/* Location: ./application/config/blog.php */