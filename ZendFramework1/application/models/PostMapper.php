<?php

class Application_Model_PostMapper
{
	protected $_dbTable;
 
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
 
	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_Post');
		}
		return $this->_dbTable;
	}
 
	public function save(Application_Model_Post $post)
	{
		$data = array(
			'id' => $post->getId(),
			'user_id' => $post->getUserId(),
			'name' => $post->getName(),
			'slug' => $post->getSlug(),
			'content' => $post->getContent(),
			'created' => date('Y-m-d H:i:s'),
		);
 
		if (null === ($id = $post->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}
 
	public function find($id, Application_Model_Post $post)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$post->setId($row->id)
			->setCategory_id($row->category_id)
			->setUser_id($row->user_id)
			->setName($row->name)
			->setSlug($row->slug)
			->setContent($row->content)
			->setCreated($row->created);
	}
 
	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Post();
			$entry->setId($row->id)
				->setCategory_id($row->category_id)
				->setUser_id($row->user_id)
				->setName($row->name)
				->setSlug($row->slug)
				->setContent($row->content)
				->setCreated($row->created);
			$entries[] = $entry;
		}
		return $entries;
	}
}