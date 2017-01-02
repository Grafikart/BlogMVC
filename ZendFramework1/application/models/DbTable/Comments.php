<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{

	protected $_name = 'comments';

	/**
	 * Get an Comment by it's primary key
	 * @param $id (Integer)
	 * @return Application_Model_Comment
	 */
	function findById($id) {
		$result = $this->find($id);
		if (0 == count($result)) {
			throw new Exception("Can't find Comment n°$id");
		}else{
			$row = $result->current();
			$user = new Application_Model_Comment();
			$user->hydrate_from_sql_row($row);
			return $user;
		}
	}

	/**
	 * Get an Comment by it's username
	 * @param $id (String)
	 * @return Application_Model_Comment
	 */
	function findByCommentname($username) {
		$result = $this->fetchRow(
			$this->select()
				->where( 'username= :username' )
				->bind(array(':username'=>$username))
		);
		if (0 == count($result)) {
			throw new Exception("Can't find Comment with username = $username");
		}else{
			$user = new Application_Model_Comment();
			$user->hydrate_from_sql_row($result);
			return $user;
		}
	}


	/**
	 * Get all Comments
	 * @yield Application_Model_Comment
	 */
	function all() {
		$results = $this->fetchAll();
		foreach ($results as $row) {
			yield Application_Model_Comment::from_sql_row($row);
		}
	}

	/**
	 * Get all posts by column and its value
	 * @param $column (String) as column name
	 * @param $value (String) as value searched
	 * @yield Application_Model_Post
	 */
	function findAllBy($column, $value) {
		$results = $this->fetchAll(
			$this->select()
				->where( "$column = :$column" )
				->bind(array(":$column"=>$value))
		);

		foreach ($results as $result) {
			$post = new Application_Model_Comment();
			yield $post->hydrate_from_sql_row($result);
		}
	}


	/**
	 * 
	 */
	public function save(Application_Model_Comment $user)
	{
		// create an arry with data
		$data = array(
			'id' => $user->getId(),
			'username' => $user->getCommentname(),
			'password' => $user->getPassword(),
		);

		if ( $id = $user->getId() ) {
			$this->update($data, array('id = ?' => $id));

		} else {
			unset($data['id']);
			$this->insert($data);
		}
	}


	/**
	 * 
	 */
	public function deleteComment(Application_Model_Comment $user)
	{
		$this->delete('id ='.$user->getId());
	}
}