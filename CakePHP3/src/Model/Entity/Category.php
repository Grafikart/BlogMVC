<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity.
 */
class Category extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'slug' => true,
        'post_count' => true,
        'posts' => true,
    ];

    public function _getUrl(){
        return ['controller' => 'Posts', 'action' => 'index', 'category' => $this->slug];
    }
}
