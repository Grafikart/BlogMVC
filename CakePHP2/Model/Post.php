<?php
class Post extends AppModel{

    public $order = 'Post.created DESC, Post.id DESC';

    // Relations
    public $belongsTo = array(
        'Category' => array(
            'counterCache' => true
        ),
        'User',
    );
    public $hasMany = array(
        'Comment' => array(
            'order' => 'Comment.created DESC'
        )
    );

    // Data validations
    public $validate = array(
        'name' => 'notEmpty',
        'slug' => array(
            'unicity' => array(
                'rule' => 'isUnique',
                'message' => 'Slug already used'
            ),
            'format' => array(
                'rule' => '/^[a-z0-9\-]+$/',
                'message' => 'Slug malformed'
            )
        ),
        'content' => 'notEmpty'
    );

    /**
    * After getting data we add an extra field "url" to avoid extra arrays in the views and extra Routes resolution
    **/
    public function afterFind($results, $primary = false){
        foreach($results as $k => $result){
            if(isset($result[$this->alias]['slug'])){
                $results[$k][$this->alias]['url'] = '/' . $result[$this->alias]['slug'];
            }
        }
        return parent::afterFind($results, $primary);
    }

    /**
    * Before saving data
    * If slug is empty we "generate" the slug from the post title
    **/
    public function beforeSave($options = array()){
        if(isset($this->data[$this->alias]['name']) && isset($this->data[$this->alias]['slug']) && empty($this->data[$this->alias]['slug'])){
            $this->data[$this->alias]['slug'] = strtolower(Inflector::slug($this->data[$this->alias]['name'], '-'));
        }
        return parent::beforeSave($options);
    }



}