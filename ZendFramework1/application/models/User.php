<?php

class Application_Model_User
{

	protected $_id;
	protected $_username;
	protected $_password;


	/** 
	 * Instanciate a Post from an SQL row
	 * @param $row Array as SQL row
	 * @return Post
	 */
	static function from_sql_row($row)
	{
		$post = new Application_Model_Post();
		return $post->hydrate_from_sql_row($row);
	}


	function __construct(array $options = null)
	{
		if($options){
			$this->setOptions($options);
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
 
	function __set($name, $value)
	{
		$method = 'set' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception("Can't set property $name");
		}
		$this->$method($value);
	}
 
	function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception("Can't get property $name");
		}
		return $this->$method();
	}
 
	function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
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

