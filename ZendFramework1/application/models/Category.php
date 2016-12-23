<?php

class Application_Model_Category
{

	protected $_id;
	protected $_name;


	/** 
	 * Instanciate a Post from an SQL row
	 * @param $row Array as SQL row
	 * @return Post
	 */
	static function from_sql_row($row)
	{
		$user = new Application_Model_Category();
		return $user->hydrate_from_sql_row($row);
	}


	function __construct(array $options = null)
	{
		if($options){
			$this->setOptions($options);
		}
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
			->setName($row->name) ;
	}


	function getId(){return $this->_id;}
	function setId($id){
		$this->_id = $id ;
		return $this;
	}

	function getName(){return $this->_name;}
	function setName($username){
		$this->_name = $username ;
		return $this;
	}


}

