<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{	
	public function get_user($login,$password) 
	{
		return $this->db
			->where('username',$login)
			->where('password',$password)
			->get('users')
			->row();
	}
}
?>