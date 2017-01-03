<?php

class Application_Model_Category extends Application_Model_ActiveRecord
{
    protected $_id;
    protected $_name;
    protected $_slug;

    use Slug;

    public function posts()
    {
        $posts = new Application_Model_DbTable_Posts();
        foreach ($posts->findAllBy('category_id', $this->id) as $post) {
            yield $post;
        }
    }


    public function hydrate_from_sql_row($row)
    {
        return $this->setId($row->id)
            ->setName($row->name)
            ->setSlug($row->slug) ;
    }

    /**
     * Export data to populate form
     * @return Array as data
     */
    public function formData()
    {
        return array(
            'id' => $this->_id,
            'name' => $this->_name,
            'slug' => $this->_slug
        );
    }


    public function getId()
    {
        return $this->_id;
    }
    public function setId($id)
    {
        $this->_id = $id ;
        return $this;
    }


    public function getName()
    {
        return $this->_name;
    }
    public function setName($username)
    {
        $this->_name = $username ;
        return $this;
    }

    public function getSlug()
    {
        return $this->_slug;
    }
    public function setSlug($slug)
    {
        $this->_slug = $slug;
        return $this;
    }
}
