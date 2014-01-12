<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Controller;

use Zend\View\Model\ViewModel;

use Blog\Form\CommentForm;
use Blog\Entity\Comment;
use Blog\Form\PostForm;
use Blog\Entity\Post;

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

        $data = $this->getPaginator('Blog\Entity\Post', 'getActivePost', array('criteria' => $criteria));

        return new ViewModel(array(
            'paginator' => $data['paginator'],
            'posts'     => $data['items'],
            'category'  => (isset($criteria['category']) ? $criteria['category'] : null),
            'user'      => (isset($criteria['user']) ? $criteria['user'] : null),
        ));
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

        $form->setHydrator($this->getDoctrineEntityHydrator());
        $form->bind($comment);

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
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

        return new ViewModel(array(
            'post' => $post,
            'form' => $form,
        ));
    }

    /** Admin **/

    public function indexAdminAction()
    {
        $data = $this->getPaginator('Blog\Entity\Post', 'getActivePost');

        return new ViewModel(array(
            'paginator' => $data['paginator'],
            'posts'     => $data['items'],
        ));
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

        $this->generateCache();

        $this->flashMessenger()->addSuccessMessage($this->getTranslation('POST_DELETED'));

        return $this->redirect()->toRoute('admin/posts');
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        $request = $this->getRequest();
        $form    = new PostForm($this->getEntityManager());
        $post    = $this->getEntityManager()->getRepository('Blog\Entity\Post')->findOneBy(array(
            'id' => $id,
        ));

        if (null == $post) {
            $post = new Post();
        }

        $form->setHydrator($this->getDoctrineEntityHydrator());
        $form->bind($post);

        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                if (null == $id) {
                    $this->generateCache();
                }

                $this->getEntityManager()->persist($post);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_POST'));

                return $this->redirect()->toRoute('admin/posts/edit', array(
                    'id' => $post->getId(),
                ));
            } else {
                $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_POST'));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'post' => $post,
        ));
    }

    private function generateCache()
    {
        $posts = $this->getEntityManager()->getRepository('Blog\Entity\Post')->getLastPost();
        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $view     = $renderer->render('layout/sidebar', array('posts' => $posts, 'categories' => $categories));

        file_put_contents($this->getCacheDirectory() . '/sidebar.cache', $view);
    }
}
