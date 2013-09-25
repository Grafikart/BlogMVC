<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends CoreController
{
    public function indexAction()
    {
        $criteria = array();

        if (null != $this->params()->fromRoute('category')) {
            $criteria['category'] = $this->params()->fromRoute('category');
        }

        if (null != $this->params()->fromRoute('user')) {
            $criteria['user'] = $this->params()->fromRoute('user');
        }

        $data = $this->getPaginator('Blog\Entity\Post', 'getActivePost', array('criteria' => $criteria));

        return array(
            'paginator' => $data['paginator'],
            'posts'     => $data['items'],
            'category'  => (isset($criteria['category']) ? $criteria['category'] : null),
            'user'      => (isset($criteria['user']) ? $criteria['user'] : null),
        );
    }

    public function showAction()
    {
        $slug = $this->params()->fromRoute('slug');

        $post = $this->getEntityManager()->getRepository('Blog\Entity\Post')->findOneBy(array(
            'slug' => $slug,
        ));

        if (null == $post) {
            $this->flashMessenger()->addErrorMessage('Cannot find post with slug "' . $slug . '"');

            return $this->redirect()->toRoute('posts');
        }

        return array(
            'post' => $post,
        );
    }
}
