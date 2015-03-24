<?php
namespace App\Controller\Admin;

use App\Controller\AppController as Controller;

/**
 * App Controller
 *
 * @property \App\Model\Table\AppTable $App
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->deny();
    }
}
