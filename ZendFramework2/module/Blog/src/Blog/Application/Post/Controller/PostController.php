<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Application\Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Blog\Core\Controller\CoreController;
use Blog\Application\Post\Form\CommentForm;
use Blog\Business\Entity\Comment;

class PostController extends CoreController
{
    public function indexAction()
    {
        $criteria = array();

        if (null != $this->params()->fromRoute('category')) {
            $criteria['category'] = $this->params()->fromRoute('category');
        }

        if (null != $this->params()->fromRoute('author')) {
            $criteria['user'] = $this->params()->fromRoute('user');
        }

        $data = $this->getPaginator('Blog\Business\Entity\Post', 'getActivePost', array('criteria' => $criteria));

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

        $post = $this->getEntityManager()->getRepository('Blog\Business\Entity\Post')->findOneBy(array(
            'slug' => $slug,
        ));

        if (null == $post) {
            $this->flashMessenger()->addErrorMessage($this->getTranslation('POST_NOT_FOUND_SLUG', array($slug)));

            return $this->redirect()->toRoute('posts');
        }

        $request = $this->getRequest();
        $form    = new CommentForm();
        $comment = new Comment();

        $form->bind($comment);

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $hydrator = $this->getDoctrineEntityHydrator();
                $comment  = $hydrator->hydrate($data->toArray(), $comment);

                $comment->setPost($post);
                $comment->setCreated(new \DateTime());

                $this->getEntityManager()->persist($comment);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_COMMENT'));

                return $this->redirect()->toRoute('posts/show', array(
                    'slug' => $post->getSlug(),
                ));
            } else {
                $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_COMMENT'));
            }
        }

        return array(
            'post' => $post,
            'form' => $form,
        );
    }

    /** Admin **/

    public function indexAdminAction()
    {
        $data = $this->getPaginator('Blog\Business\Entity\Post', 'getActivePost');

        return array(
            'paginator' => $data['paginator'],
            'posts'     => $data['items'],
        );
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        $post = $this->getEntityManager()->getRepository('Blog\Business\Entity\Post')->findOneBy(array(
            'id' => $id,
        ));

        if (null == $post) {
            $this->flashMessenger()->addErrorMessage($this->getTranslation('POST_NOT_FOUND_ID', array($id)));

            return $this->redirect()->toRoute('admin/posts');
        }

        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();

        $this->flashMessenger()->addSuccessMessage($this->getTranslation('POST_DELETED'));

        return $this->redirect()->toRoute('admin/posts');
    }
}
