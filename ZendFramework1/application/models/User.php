<?php

class Application_Model_User extends Application_Model_ActiveRecord
{

	protected $_id;
	protected $_username;
	protected $_password;



	function posts(){
		$posts = new Application_Model_DbTable_Posts();
		foreach($posts->findAllBy('user_id', $this->id) as $user){
			yield $user;
		}
	}

	/**
	 * Check if password correspond to the crypted password
	 * @param $password (String) as clear pasword
	 * @return (Boolean) true if correspond
	 */
	function isPassword($password){
		return $this->encrypt($password) === $this->_password ;
	}
 

	function hydrate_from_sql_row($row){
		return $this->setId($row->id)
			->setUsername($row->username)
			->setPassword($row->password);
	}

	/**
	 * Export data to populate form
	 * @return Array as data
	 */
	function formData(){
		return array(
			'id' => $this->_id,
			'username' => $this->_username,
			'password' => $this->_password,
		);
	}


	function getId(){return $this->_id;}
	function setId($id){
		$this->_id = $id ;
		return $this;
	}

	function getUsername(){return $this->_username;}
	function setUsername($username){
		$this->_username = $username ;
		return $this;
	}

	function getPassword(){return $this->_password;}
	function setPassword($password){
		$this->_password = $password ;
		return $this;
	}

	private function encrypt($string){
		return sha1($string);
	}

}

