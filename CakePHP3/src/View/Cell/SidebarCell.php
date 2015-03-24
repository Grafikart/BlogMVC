<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Sidebar cell
 */
class SidebarCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->loadModel('Posts');
        $this->loadModel('Categories');
        $posts = $this->Posts->find('all')->limit(2)->select(['id', 'slug', 'name']);
        $categories = $this->Categories->find('all');
        $this->set(compact('posts', 'categories'));
    }
}
