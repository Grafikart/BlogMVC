<?php

class Application_Model_Category extends Application_Model_ActiveRecord
{

	protected $_id;
	protected $_name;


	

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

