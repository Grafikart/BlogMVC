<?php


class Application_Model_Post
{
	protected $_id;
	protected $_category_id;
	protected $_user_id;
	protected $_name;
	protected $_slug;
	protected $_content;
	protected $_created;


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

	/**
	 * Find a Post by their id
	 * @param $id Interger as Post id
	 * @return Post as post founded
	 * @return Null if not founded
	 */
	static function from_id($id)
	{
		$post = new Application_Model_Post();
		$map = new Application_Model_PostMapper();
		return $map->find($id, $post);
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
			->setCategoryId($row->category_id)
			->setUserId($row->user_id)
			->setName($row->name)
			->setSlug($row->slug)
			->setContent($row->content)
			->setCreated($row->created);
	}

	/**
	 * Export data to populate form
	 * @return Array as data
	 */
	function formData(){
		return array(
			'id' => $this->_id,
			'name' => $this->_name,
			'content' => $this->_content,
			'categoryId' => $this->_category_id,
			'userId' => $this->_user_id
		);
	}
 
	
	function getId(){ return $this->_id; }
	function setId($id)
	{
		$this->_id = $id;
		return $this;
	}

	function getCategoryId(){ return $this->_category_id; }
	function setCategoryId($category_id)
	{
		$this->_category_id = $category_id;
		return $this;
	}

	function getUserId(){ return $this->_user_id; }
	function setUserId($user_id)
	{
		$this->_user_id = $user_id;
		return $this;
	}

	function getName(){ return $this->_name; }
	function setName($name)
	{
		$this->_name = $name;
		return $this;
	}

	function getSlug(){ return $this->_slug; }
	function setSlug($slug)
	{
		$this->_slug = $slug;
		return $this;
	}

	function getContent(){ return $this->_content; }
	function setContent($content)
	{
		$this->_content = $content;
		return $this;
	}

	function getCreated(){ return $this->_created; }
	function setCreated($timestamp)
	{
		$this->_created = $timestamp;
		return $this;
	}
}