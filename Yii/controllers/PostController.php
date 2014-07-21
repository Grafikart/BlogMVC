<?php

/**
 * This controller handles basic CRUD work posts.
 * If you're not familiar with MVC system, please note that controller
 * actions should be much more thin than the ones you can find here. Fat
 * actions are the first sign of bad architecture and non-reusable code. The
 * only reason i didn't i clean it up is that i didn't have enough time.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class PostController extends \BaseController
{
    /**
     * Main action, renders last 5 posts from the feed.
     * 
     * @throws \EHttpException Raises HTTP error 402 if unknown format is
     * requested.
     * @throws \EHttpException Raises HTTP error 404 if requested feed page
     * doesn't exist (except for the first page).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionIndex()
    {
        $posts = \Post::model()
            ->paged($this->page->pageNumber)
            ->with('author')
            ->findAll();
        if ($this->page->pageNumber > 1 && sizeof($posts) === 0) {
            throw new \EHttpException(404);
        }
        $this->page->totalPages = \Post::model()->totalPages();
        $this->page->headingDescription = \Yii::t(
            'templates',
            'text.welcomeMessage'
        );
        $this->page->resetHeading();
        $this->render('index', array('posts' => $posts,), $posts);
    }

    /**
     * Shows selected post in chosen format.
     *
     * @param string $slug   Post slug.
     *
     * @throws \EHttpException Thrown if requested post doesn't exist or can't be
     * formatted using provided format.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionShow($slug)
    {
        $post = \Post::model()->with('comments')->find(
            'slug = :slug',
            array(':slug' => $slug,)
        );
        if ($post === null) {
            throw new \EHttpException(404);
        }
        $comment = new \Comment;
        if (\Yii::app()->user->hasData('comment')) {
            $comment->setAndValidate(\Yii::app()->user->getData('comment'));
        }
        $this->page->resetTitle(array('{postTitle}' => $post->name));
        $data = array('post' => $post, 'comment' => $comment,);
        $this->render('show', $data, $post);
    }

    /**
     * Renders form for new post.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionNew()
    {
        $post = new Post;
        $category = new \Category;
        $data = \Yii::app()->request->getPost('Post', false);
        $categoryData = \Yii::app()->request->getPost('Category', false);
        $failed = false;
        if ($categoryData) {
            if (!$category->setAndSave($categoryData)) {
                $failed = true;
            } else {
                $post->category_id = $category->getPrimaryKey();
            }
        }
        if ($data && !$failed && $post->setAndSave($data)) {
            \Yii::app()->user->sendNotice('post.submit.success');
            $this->redirect(array('post/show', 'slug' => $post->slug));
        }
        $templateVars = array(
            'post' => $post,
            'categories' => \Category::model()->getList(),
            'category' => $category,
        );
        $this->render('form', $templateVars);
    }

    /**
     * Returns post slug existence.
     *
     * @param string $slug Slug to be checked.
     *
     * @throws \EHttpException Thrown if requested non-ajaxly in production
     * mode.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionCheckSlug($slug)
    {
        if (!\Yii::app()->request->isAjaxRequest && (!defined('YII_DEBUG')
            || !YII_DEBUG)
        ) {
            throw new \EHttpException(400, 'badRequest.ajaxOnly');
        }
        echo CJSON::encode(Post::model()->slugExists($slug));
    }

    /**
     * Renders form for post editing.
     *
     * @param int $id Post ID.
     *
     * @throws \EHttpException Thrown if post doesn't exist (404).
     * @throws \EHttpException Thrown if post wasn't written by current user
     * (403).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionEdit($id)
    {
        /** @type \Post $model */
        $model = \Post::model()->findByPk($id);
        if ($model === null) {
            throw new \EHttpException(404);
        } else if ((int) $model->user_id !== \Yii::app()->user->id) {
            throw new \EHttpException(403, 'notAuthorized.postOwnership');
        }
        $data = \Yii::app()->request->getPost('Post');
        $categoryData = \Yii::app()->request->getPost('Category');
        $failed = false;
        $category = new \Category;
        if ($categoryData) {
            if (!$category->setAndSave($categoryData)) {
                $failed = true;
            } else {
                $model->category_id = $category->getPrimaryKey();
            }
        }
        if ($data && !$failed) {
            $model->setAndSave($data);
        }
        $this->pageTitle = $model->name;
        $url = $this->createUrl('post/show', array('slug' => $model->slug));
        $this->page->addNavigationItem($url, 'link.viewPost');
        $templateVars = array(
            'post' => $model,
            'categories' => \Category::model()->getList(),
            'category' => $category
        );
        $this->render('form', $templateVars);
    }

    /**
     * Deletes post with selected ID.
     *
     * @param int|string $id Post ID.
     *
     * @throws \EHttpException Thrown if post doesn't exist (404).
     * @throws \EHttpException Thrown if post wasn't written by current user
     * (403).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDelete($id)
    {
        if (!($model = \Post::model()->findByPk($id))) {
            throw new \EHttpException(404);
        }
        if ((int) $model->user_id !== \Yii::app()->user->id) {
            throw new \EHttpException(403, 'notAuthorized.postOwnership');
        }
        $model->delete();
        if (\Yii::app()->getRequest()->getIsAjaxRequest()) {
            echo \CJSON::encode(array('success' => true,));
        } else {
            \Yii::app()->user->sendSuccessMessage(
                'post.delete.success',
                array('{title}' => $model->name,)
            );
            $this->redirect(array('post/dashboard'));
        }
    }

    /**
     * Renders posts dashboard.
     *
     * @throws \EHttpException Thrown if such page doesn't exist (404).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDashboard()
    {
        $this->page->totalPages = \Post::model()->totalPages(10);
        $posts = \Post::model()
            ->paged($this->page->pageNumber, 10)
            ->by(\Yii::app()->user->id)
            ->findAll();
        if (empty($posts) && !$this->page->isFirstPage()) {
            throw new \EHttpException(404);
        }
        $this->render('dashboard', array('posts' => $posts,), $posts);
    }

    /**
     * Defines controller filters.
     *
     * @return array Set of controller filters.
     * @since 0.1.0
     */
    public function filters()
    {
        return array('accessControl');
    }

    /**
     * Defines access rules for actions.
     *
     * @return array Set of access rules.
     * @since 0.1.0
     */
    public function accessRules()
    {
        return array(
            array(
                'deny',
                'users' => array('?'),
                'actions' => array(
                    'new',
                    'checkSlug',
                    'edit',
                    'delete',
                    'dashboard',
                ),
            ),
            array('allow',),
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getActionAncestors()
    {
        return array(
            'index' => null,
            'show' => 'index',
            'edit' => 'dashboard',
            'dashboard' => 'admin/index',
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return array Actions navigation links definitions.
     * @since 0.1.0
     */
    public function navigationLinks()
    {
        return array(
            'edit' => array('index', 'dashboard'),
            'new' => array('index', 'dashboard'),
            'dashboard' => array(
                array(
                    'route' => 'new',
                    'title' => 'link.createNewPost',
                    'type' => 'button',
                )
            ),
        );
    }
}
