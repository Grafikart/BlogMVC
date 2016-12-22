<?php

class Application_Model_DbTable_Posts extends Zend_Db_Table_Abstract
{

	protected $_name = 'posts';

	/**
	 * 
	 */
	function findById($id) {
		$result = $this->find($id);
		if (0 == count($result)) {
			throw new Exception("Can't find User n°$id");
		}else{
			$row = $result->current();
			$post = new Application_Model_Post();
			$post->hydrate_from_sql_row($row);
			return $post;
		}
	}

	/**
	 * Get all posts by user id
	 * @param $user_id (Integer)
	 * @yield Application_Model_User
	 */
	function findAllByUserId($user_id) {
		$results = $this->fetchAll(
			$this->select()
				->where( 'user_id= :user_id' )
				->bind(array(':user_id'=>$user_id))
		);

		foreach ($results as $result) {
			$post = new Application_Model_Post();
			yield $post->hydrate_from_sql_row($result);
		}
	}


	/**
	 * 
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
	public function save(Application_Model_Post $post)
	{
		// create an arry with data
		$data = array(
			'id' => $post->getId(),
			'user_id' => $post->getUserId(),
			'category_id' => $post->getCategoryId(),
			'name' => $post->getName(),
			'slug' => $post->getSlug(),
			'content' => $post->getContent(),
			'created' => time()
		);

		if ( $id = $post->getId() ) {
			$this->update($data, array('id = ?' => $id));

		} else {
			unset($data['id']);
			$data['created'] = time();
			$this->insert($data);
		}
	}


	/**
	 * 
	 */
	public function deletePost(Application_Model_Post $post)
	{
		$this->delete('id ='.$post->getId());
	}
}