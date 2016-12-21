<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

	protected $_name = 'users';

	/**
	 * Get an User by it's primary key
	 * @param $id (Integer)
	 * @return Application_Model_User
	 */
	function findById($id) {
		$result = $this->find($id);
		if (0 == count($result)) {
			throw new Exception("Can't find Post n°$id");
		}else{
			$row = $result->current();
			$post = new Application_Model_Post();
			$post->hydrate_from_sql_row($row);
			return $post;
		}
	}

	/**
	 * Get an User by it's username
	 * @param $id (String)
	 * @return Application_Model_User
	 */
	function findByUsername($username) {
		$result = $this->fetchRow(
			$this->select()
				->where( 'username= :username' )
				->bind(array(':username'=>$username))
		);
		if (0 == count($result)) {
			throw new Exception("Can't find User with username = $username");
		}else{
			$user = new Application_Model_User();
			$user->hydrate_from_sql_row($result);
			return $user;
		}
	}


	/**
	 * Get all Users
	 * @yield Application_Model_User
	 */
	function all() {
		$results = $this->fetchAll();
		foreach ($results as $row) {
			yield Application_Model_Post::from_sql_row($row);
		}
	}


	/**
	 * 
	 */
	public function save(Application_Model_User $user)
	{
		// create an arry with data
		$data = array(
			'id' => $user->getId(),
			'username' => $user->getUsername(),
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
	public function deletePost(Application_Model_User $user)
	{
		$this->delete('id ='.$user->getId());
	}
}