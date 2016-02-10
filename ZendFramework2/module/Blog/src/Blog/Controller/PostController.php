<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Controller;

use Blog\Form\AddPostForm;
use Blog\Service\CommentService;
use Blog\Service\PostService;
use Zend\View\Model\ViewModel;

use Blog\Form\CommentForm;
use Blog\Entity\Comment;
use Blog\Form\EditPostForm;
use Blog\Entity\Post;

class PostController extends CoreController
{
    /** @var  PostService */
    private $postService;

    /** @var  CommentService */
    private $commentService;

    /** @var  CommentForm */
    private $commentForm;

    /** @var  EditPostForm */
    private $editPostForm;

    /** @var  AddPostForm */
    private $addPostForm;

    public function __construct(
        PostService $postService,
        CommentService $commentService,
        CommentForm $commentForm,
        EditPostForm $editPostForm,
        AddPostForm $addPostForm
    ) {
        $this->postService    = $postService;
        $this->commentService = $commentService;
        $this->commentForm    = $commentForm;
        $this->editPostForm   = $editPostForm;
        $this->addPostForm    = $addPostForm;
    }

    public function indexAction()
    {
        $criteria = array();

        $page     = $this->params('page', 1);
        $category = $this->params('category', null);
        $author   = $this->params('author', null);

        if ($category) {
            $criteria['category'] = $category;
        }

        if ($author) {
            $criteria['author'] = $author;
        }

        $posts = $this->postService->getActivePost($criteria);
        $posts->setItemCountPerPage(5)
            ->setCurrentPageNumber($page);

        return new ViewModel(array(
            'posts'    => $posts,
            'category' => (isset($criteria['category']) ? $criteria['category'] : null),
            'author'   => (isset($criteria['author']) ? $criteria['author'] : null),
        ));
    }

    public function showAction()
    {
        $slug = $this->params('slug', null);

        if (!$slug) {
            return $this->redirect()->toRoute('home');
        }

        $post = $this->postService->getPostBySlug($slug);

        if (!$post) {
            $this->flashMessenger()->addErrorMessage($this->getTranslation('POST_NOT_FOUND_SLUG', array($slug)));

            return $this->redirect()->toRoute('posts');
        }

        $request = $this->getRequest();
        $comment = new Comment();

        $this->commentForm->bind($comment);

        if ($request->isPost()) {
            $data = $request->getPost();
            $this->commentForm->setData($data);

            if ($this->commentForm->isValid()) {
                /** @var Comment $comment */
                $comment = $this->commentForm->getData();
                $this->commentService->addComment($comment, $post);

                $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_COMMENT'));

                return $this->redirect()->toRoute('posts/show', array(
                    'slug' => $post->getSlug(),
                ));
            }
        }

        return new ViewModel(array(
            'post' => $post,
            'form' => $this->commentForm,
        ));
    }

    /** Admin **/

    public function indexAdminAction()
    {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('home');
        }
        $page = $this->params('page', 1);

        $posts = $this->postService->getActivePost();
        $posts->setItemCountPerPage(5)
            ->setCurrentPageNumber($page);

        return new ViewModel(array(
            'posts' => $posts,
        ));
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $post = $this->postService->getPostById($id);

        if (!$post) {
            $this->flashMessenger()->addErrorMessage($this->getTranslation('POST_NOT_FOUND_ID', array($id)));

            return $this->redirect()->toRoute('admin/posts');
        }

        $this->postService->deletePost($post);

        $this->flashMessenger()->addSuccessMessage($this->getTranslation('POST_DELETED'));

        return $this->redirect()->toRoute('admin/posts');
    }

    public function editAction()
    {
        $id = $this->params('id');

        $request = $this->getRequest();
        $post    = $this->postService->getPostById($id);

        if (!$post) {
            return $this->redirect()->toRoute('admin/posts');
        }

        $this->editPostForm->bind($post);

        if ($request->isPost()) {
            $data = $request->getPost();
            $this->editPostForm->setData($data);

            if ($this->editPostForm->isValid()) {
                $post = $this->editPostForm->getData();
                $this->postService->updatePost($post);

                $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_POST'));

                return $this->redirect()->toRoute('admin/posts/edit', array(
                    'id' => $post->getId(),
                ));
            } else {
                $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_POST'));
            }
        }

        return new ViewModel(array(
            'form' => $this->editPostForm,
        ));
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $post = new Post();
        $this->addPostForm->bind($post);

        if ($request->isPost()) {
            $data = $request->getPost();
            $this->addPostForm->setData($data);

            if ($this->addPostForm->isValid()) {
                $post = $this->addPostForm->getData();
                $this->postService->addPost($post);

                $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_POST'));

                return $this->redirect()->toRoute('admin/posts/edit', array(
                        'id' => $post->getId(),
                    ));
            } else {
                $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_POST'));
            }
        }

        return new ViewModel(array(
            'form' => $this->addPostForm,
        ));
    }
}
