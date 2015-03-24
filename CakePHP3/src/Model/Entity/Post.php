<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;

/**
 * Post Entity.
 */
class Post extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'category_id' => true,
        'name' => true,
        'slug' => true,
        'content' => true,
        'category' => true,
    ];

    public function _getUrl(){
        return ['controller' => 'Posts', 'action' => 'view', 'slug' => $this->slug];
    }

    public function _setSlug($slug){
        if(empty($slug)){
            return strtolower(Inflector::slug($this->name));
        }
    }
}
