<?php

class Application_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{

	protected $_name = 'categories';

	/**
	 * Get an Category by it's primary key
	 * @param $id (Integer)
	 * @return Application_Model_Category
	 */
	function findById($id) {
		$result = $this->find($id);
		if (0 == count($result)) {
			throw new Exception("Can't find Category n°$id");
		}else{
			$row = $result->current();
			$category = new Application_Model_Category();
			$category->hydrate_from_sql_row($row);
			return $category;
		}
	}

	/**
	 * Get an Category by it's name
	 * @param $name (String)
	 * @return Application_Model_Category
	 */
	function findByName($name) {
		$result = $this->fetchRow(
			$this->select()
				->where( 'name= :name' )
				->bind(array(':name'=>$name))
		);
		if (0 == count($result)) {
			throw new Exception("Can't find Category with name = $name");
		}else{
			$category = new Application_Model_Category();
			$category->hydrate_from_sql_row($result);
			return $category;
		}
	}


	/**
	 * Get all Categories
	 * @yield Application_Model_Category
	 */
	function all() {
		$results = $this->fetchAll();
		foreach ($results as $row) {
			yield Application_Model_Category::from_sql_row($row);
		}
	}

	/**
	 * Get all values for select/options 
	 * @return (array) as data for the select form
	 */
	function selectOptions() {
		$results = array();
		foreach ($this->all() as $category) {
			$results[$category->id] = $category->name;
		}
		return $results;
	}


	/**
	 * 
	 */
	public function save(Application_Model_Category $category)
	{
		// create an arry with data
		$data = array(
			'id' => $category->getId(),
			'name' => $category->getName(),
		);

		if ( $id = $category->getId() ) {
			$this->update($data, array('id = ?' => $id));

		} else {
			unset($data['id']);
			$this->insert($data);
		}
	}


	/**
	 * 
	 */
	public function deleteCategory(Application_Model_Category $category)
	{
		$this->delete('id ='.$category->getId());
	}
}