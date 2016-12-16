<?php

class Application_Model_PostMapper
{
	protected $_dbTable;
 
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$this->_dbTable = new $dbTable();
			return $this;

		} else if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
	}
 
	public function getDbTable()
	{
		if ($this->_dbTable === null) {
			$this->setDbTable('Application_Model_DbTable_Post');
		}
		return $this->_dbTable;
	}
 
	public function save(Application_Model_Post $post)
	{
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
			$this->getDbTable()->update($data, array('id = ?' => $id));
		} else {
			unset($data['id']);
			$data['created'] = time();
			$this->getDbTable()->insert($data);
		}
	}
 
	public function find($id, Application_Model_Post $post)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$post->hydrate_from_sql_row($row);
		return $post;
	}
 
	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		foreach ($resultSet as $row) {
			yield Application_Model_Post::from_sql_row($row);
		}
	}
}