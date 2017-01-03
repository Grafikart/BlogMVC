<?php


abstract class Application_Model_ActiveRecord
{
    
    /**
     * Instanciate a Post/User/Category from an SQL row
     * @param $row Array as SQL row
     * @return Post
     * @return User
     * @return Category
     */
    public static function from_sql_row($row)
    {
        $user = new static;
        return $user->hydrate_from_sql_row($row);
    }


    public function __construct(array $options = null)
    {
        if ($options) {
            $this->setOptions($options);
        }
    }

    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception("Can't set property $name");
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception("Can't get property $name");
        }
        return $this->$method();
    }


    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
}
