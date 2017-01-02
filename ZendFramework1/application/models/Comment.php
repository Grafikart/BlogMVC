<?php

class Application_Model_Comment extends Application_Model_ActiveRecord{
	protected $_id;
	protected $_post_id;
	protected $_username;
	protected $_mail;
	protected $_content;
	protected $_created;




	function post(){
		$posts = new Application_Model_DbTable_Posts();
		return $posts->findBy('id', $this->_post_id);
	}

	/**
	 * Check if comment is valid (check if email is valid)
	 * @param $password (String) as clear pasword
	 * @return (Boolean) true if correspond
	 */
	function isValid($email){
		// TODO Regex validation
		return true ;
	}


	/**
	 * Count days between Comment's creation and today
	 * @return (Integer) as number of days
	 */
	function days(){
		$today = new DateTime();
		$created = DateTime::createFromFormat('U', $this->created);
		return $today->diff($created)->days;
	}
 

	function hydrate_from_sql_row($row){
		return $this->setId($row->id)
			->setPostId($row->post_id)
			->setUsername($row->username)
			->setMail($row->mail)
			->setContent($row->content)
			->setCreated($row->created);
	}


	function getId(){return $this->_id;}
	function setId($id){
		$this->_id = $id ;
		return $this;
	}

	function getPostId(){return $this->_post_id;}
	function setPostId($post_id){
		$this->_post_id = $post_id ;
		return $this;
	}

	function getUsername(){return $this->_username;}
	function setUsername($username){
		$this->_username = $username ;
		return $this;
	}

	function getMail(){return $this->_mail;}
	function setMail($mail){
		$this->_mail = $mail ;
		return $this;
	}

	function getContent(){return $this->_content;}
	function setContent($content){
		$this->_content = $content ;
		return $this;
	}

	function getCreated(){return $this->_created;}
	function setCreated($created){
		$this->_created = $created ;
		return $this;
	}

	

}