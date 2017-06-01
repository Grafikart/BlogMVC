<?php

class Application_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{
    protected $_name = 'categories';

    /**
     * Get an Category by it's primary key
     * @param $id (Integer)
     * @return Application_Model_Category
     */
    public function findById($id)
    {
        $result = $this->find($id);
        if (0 == count($result)) {
            throw new Exception("Can't find Category n°$id");
        } else {
            $row = $result->current();
            $category = new Application_Model_Category();
            $category->hydrate_from_sql_row($row);
            return $category;
        }
    }


    /**
     * Get first post by column and its value
     * @param $column (String) as column name
     * @param $value (String) as value searched
     * @return Application_Model_Post if founded
     */
    public function findBy($column, $value)
    {
        foreach ($this->findAllBy($column, $value) as $post) {
            return $post;
        }
    }


    /**
     * Get all posts by column and its value
     * @param $column (String) as column name
     * @param $value (String) as value searched
     * @yield Application_Model_Post
     */
    public function findAllBy($column, $value)
    {
        $results = $this->fetchAll(
            $this->select()
                ->where("$column = :$column")
                ->bind(array(":$column"=>$value))
        );

        foreach ($results as $result) {
            $category = new Application_Model_Category();
            yield $category->hydrate_from_sql_row($result);
        }
    }


    /**
     * Get all Categories
     * @yield Application_Model_Category
     */
    public function all()
    {
        $results = $this->fetchAll();
        foreach ($results as $row) {
            yield Application_Model_Category::from_sql_row($row);
        }
    }

    /**
     * Get all values for select/options
     * @return (array) as data for the select form
     */
    public function selectOptions()
    {
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
            'slug' => $category->generateSlug(),
        );

        if ($id = $category->getId()) {
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
