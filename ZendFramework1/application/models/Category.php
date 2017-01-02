<?php
require_once 'Slug.php';


class Application_Model_Category extends Application_Model_ActiveRecord
{

	protected $_id;
	protected $_name;
	protected $_slug;

	use Slug;

	function posts(){
		$posts = new Application_Model_DbTable_Posts();
		foreach($posts->findAllBy('category_id', $this->id) as $post){
			yield $post;
		}
	}

	
	function hydrate_from_sql_row($row){
		return $this->setId($row->id)
			->setName($row->name) ;
	}

	/**
	 * Export data to populate form
	 * @return Array as data
	 */
	function formData(){
		return array(
			'id' => $this->_id,
			'name' => $this->_name,
			'slug' => $this->_slug
		);
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

	function getSlug(){ return $this->_slug; }
	function setSlug($slug)
	{
		$this->_slug = $slug;
		return $this;
	}

}