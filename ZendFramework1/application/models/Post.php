<?php

class Application_Model_Post extends Application_Model_ActiveRecord
{
	protected $_id;
	protected $_category_id;
	protected $_user_id;
	protected $_name;
	protected $_slug;
	protected $_content;
	protected $_created;

	protected $_user;
	protected $_category;



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
	 * Get user from user_id data
	 * @return Application_Model_User as user founded
	 */
	function user(){
		// check if user is already loaded, if not, we fetch it from database
		if($this->_user){
			return $this->_user;
		}else{
			$users = new Application_Model_DbTable_Users();
			if($user = $users->findById($this->_user_id)){
				$this->_user = $user;
				return $user ;
			}else{
				throw new Exception("Can't fetch user data");
			}
		}
	}

	/**
	 * Get category from category_id data
	 * @return Application_Model_Category as user founded
	 */
	function category(){
		// check if user is already loaded, if not, we fetch it from database
		if($this->_category){
			return $this->_category;
		}else{
			$categories = new Application_Model_DbTable_Categories();
			if($category = $categories->findById($this->_category_id)){
				$this->_category = $category;
				return $category ;
			}else{
				throw new Exception("Can't fetch category data");
			}
		}
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