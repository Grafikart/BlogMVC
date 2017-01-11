<?php

class Application_Model_Comment extends Application_Model_ActiveRecord
{
    protected $_id;
    protected $_post_id;
    protected $_username;
    protected $_mail;
    protected $_content;
    protected $_created;




    public function post()
    {
        $posts = new Application_Model_DbTable_Posts();
        return $posts->findBy('id', $this->_post_id);
    }

    /**
     * Check if comment is valid (check if email is valid)
     * @return (Boolean) true if correspond
     */
    public function isValid()
    {
        return filter_var($this->_mail, FILTER_VALIDATE_EMAIL);
    }


    /**
     * Count days between Comment's creation and today
     * @return (Integer) as number of days
     */
    public function days()
    {
        $today = new DateTime();
        $created = DateTime::createFromFormat('U', $this->created);
        return $today->diff($created)->days;
    }
 

    public function hydrate_from_sql_row($row)
    {
        return $this->setId($row->id)
            ->setPostId($row->post_id)
            ->setUsername($row->username)
            ->setMail($row->mail)
            ->setContent($row->content)
            ->setCreated($row->created);
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

    public function getPostId()
    {
        return $this->_post_id;
    }
    public function setPostId($post_id)
    {
        $this->_post_id = $post_id ;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }
    public function setUsername($username)
    {
        $this->_username = $username ;
        return $this;
    }

    public function getMail()
    {
        return $this->_mail;
    }
    public function setMail($mail)
    {
        $this->_mail = $mail ;
        return $this;
    }

    public function getContent()
    {
        return $this->_content;
    }
    public function setContent($content)
    {
        $this->_content = $content ;
        return $this;
    }

    public function getCreated()
    {
        return $this->_created;
    }
    public function setCreated($created)
    {
        $this->_created = $created ;
        return $this;
    }
}
