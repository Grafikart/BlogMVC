<?php

/**
 * This controller handles basic CRUD work posts.
 * If you're not familiar with MVC system, please note that controller
 * actions should be much more thin than the ones you can find here. Fat
 * actions are the first sign of bad architecture and non-reusable code. The
 * only reason i didn't i clean it up is that i didn't have enough time.
 *
 * @todo Breadcrumbs generation should be done in base controller only
 * @todo Finish post creation (slug checking)
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class PostController extends BaseController
{
    /**
     * {@inheritDoc}
     */
    public function generateBreadcrumbs($setPageTitle=true, $force=false)
    {
        if ($this->action->id === 'index') {
            $this->generateIndexBreadcrumbs();
        } else {
            parent::generateBreadcrumbs($setPageTitle, $force);
        }
    }
    /**
     * Generates breadcrumbs for index page.
     * 
     * @todo you should come with more proper naming and, possibly,
     * controller inheritance.
     * 
     * @return void
     * @since 0.1.0
     */
    public function generateIndexBreadcrumbs()
    {
        if ($this->pageNumber > 1) {
            $text = \Yii::t(
                'templates', 'breadcrumbs.pageTitle',
                array('{pageNumber}' => $this->pageNumber,)
            );
            $this->breadcrumbs = array(
                \Yii::app()->request->requestUri => $text,
            );
        }
    }
    /**
     * Method for alteration breadcrumbs for edit page.
     * 
     * @param Post $post Current post instance.
     *
     * @return void
     * @since 0.1.0
     */
    public function alterEditBreadcrumbs(Post $post)
    {
        array_pop($this->breadcrumbs);
        $this->breadcrumbs[\Yii::app()->request->requestUri] = $post->name;
    }
    /**
     * Main action, renders last 5 posts from the feed.
     *
     * @param int|string $page   Page number in string form.
     * @param string     $format Format to supply page in.
     * 
     * @throws CHttpException Raises HTTP error 402 if unknown format is
     * requested.
     * @throws CHttpException Raises HTTP error 404 if requested feed page
     * doesn't exist (except for the first page).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionIndex($page=1, $format='html')
    {
        $this->setPage($page, \Yii::t('templates', 'blog.pageTitle'));
         $format = strtolower($format);
        if ($format !== 'html' && !\DataFormatter::knownFormat($format)) {
            throw new \HttpException(400, 'badRequest.invalidFormat');
        }
        $posts = \Post::model()->paged($this->pageNumber)->with('author')->findAll();
        if ($this->pageNumber > 1 && sizeof($posts) === 0) {
            throw new \HttpException(404);
        }
        if ($format === 'html') {
            $data = array(
                'posts' => $posts,
                'pagination' => array(
                    'currentPage' => $this->pageNumber,
                    'totalPages' => \Post::model()->totalPages(),
                    'route' => 'post/index',
                ),
            );
            $this->render('index', $data);
        } else {
            echo \Yii::app()->formatter->formatModels($posts, $format);
        }
    }
    /**
     * Shows selected post in chosen format.
     *
     * @param string $slug   Post slug.
     * @param string $format Format to render post in.
     *
     * @throws \HttpException Thrown if requested post doesn't exist or can't be
     * formatted using provided format.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionShow($slug, $format='html')
    {
        $post = \Post::model()->with('comments')->find(
            'slug = :slug',
            array(':slug' => $slug,)
        );
        if ($post === null) {
            throw new \HttpException(404);
        }
        if ($format === 'html') {
            $comment = new \Comment;
            if (\Yii::app()->user->hasData('comment')) {
                $comment->setAndValidate(\Yii::app()->user->getData('comment'));
            }
            $this->render(
                'show',
                array(
                    'post' => $post,
                    'comment' => $comment,
                )
            );
        } else if (!\DataFormatter::knownFormat($format)) {
            throw new \HttpException(400, 'badRequest.invalidFormat');
        } else {
            echo \Yii::app()->formatter->formatModel($post, $format);
        }
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
        $data = \Yii::app()->request->getPost('Post', false);
        if ($data && $post->setAndSave($data)) {
            \Yii::app()->user->sendMessage('post.submit.success');
            $this->redirect(array('post/show', 'slug' => $post->slug));
        }
        $this->render(
            'form',
            array(
                'post' => $post,
                'categories' => \Category::model()->getList()
            )
        );
    }

    /**
     * Returns post slug existence.
     *
     * @param string $slug Slug to be checked.
     *
     * @throws \HttpException Thrown if requested non-ajaxly in profuction
     * mode.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionCheckSlug($slug)
    {
        if (!\Yii::app()->request->isAjaxRequest && YII_DEBUG == false) {
            throw new \HttpException(400, 'badRequest.ajaxOnly');
        }
        echo CJSON::encode(Post::model()->slugExists($slug));
    }

    /**
     * Renders form for post editing.
     *
     * @param int $id Post ID.
     *
     * @throws \HttpException Thrown if post doesn't exist (404).
     * @throws \HttpException Thrown if post wasn't written by current user
     * (403).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionEdit($id)
    {
        $model = \Post::model()->findByPk($id);
        if ($model === null) {
            throw new \HttpException(404);
        } else if ((int) $model->user_id !== \Yii::app()->user->id) {
            throw new \HttpException(403, 'notAuthorized.postOwnership');
        }
        if ($data = \Yii::app()->request->getPost('Post')) {
            $model->setAndSave($data);
        }
        $this->pageTitle = $model->name;
        $this->alterEditBreadcrumbs($model);
        $this->render(
            'form',
            array(
                'post' => $model,
                'categories' => \Category::model()->getList(),
            )
        );
    }
    /**
     * Deletes post with selected ID.
     *
     * @param int|string $id Post ID.
     *
     * @throws \HttpException Thrown if post doesn't exist (404).
     * @throws \HttpException Thrown if post wasn't written by current user
     * (403).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDelete($id)
    {
        if (($model = \Post::model()->findByPk($id)) === null) {
            throw new \HttpException(404);
        }
        if ((int)$model->user_id !== \Yii::app()->user->id) {
            throw new \HttpException(403, 'notAuthorized.postOwnership');
        }
        $model->delete();
        \Yii::app()->user->sendMessage(
            'post.delete.success',
            WebUserLayer::FLASH_SUCCESS,
            array('{title}' => $model->name,)
        );
        $this->redirect(array('post/dashboard'));
    }

    /**
     * Renders posts dashboard.
     *
     * @param int|string $page Page number.
     *
     * @throws HttpException Thrown if such page doesn't exist (404).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDashboard($page=1)
    {
        $page = $this->setPageNumber($page);
        $posts = Post::model()->paged($page, 10)->findAll();
        if (empty($posts) && $page !== 1) {
            throw new \HttpException(404);
        }
        $this->render(
            'dashboard',
            array(
                'posts' => $posts,
                'pagination' => array(
                    'currentPage' => $page,
                    'totalPages' => \Post::model()->totalPages(10),
                    'route' => 'post/dashboard',
                ),
            )
        );
    }

    /**
     * Displays all user's posts.
     *
     * @param string|int $id   User ID.
     * @param string|int $page Page number
     *
     * @throws \HttpException Thrown if such user or page isn't found (404).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionAuthor($id, $page=1)
    {
        $user = \User::model()->findByPk($id);
        if ($user === null) {
            throw new \HttpException(404);
        }
        $this->setPage($page);
        $posts = \Post::model()->paged($this->pageNumber)->findAll(
            'user_id = :user_id',
            array(':user_id' => $user->getPrimaryKey())
        );
        if (sizeof($posts) === 0 && $this->pageNumber > 1) {
            throw new \HttpException(404);
        }
        $this->render(
            'index',
            array(
                'user' => $user,
                'posts' => $posts,
                'pagination' => array(
                    'currentPage' => $this->pageNumber,
                    'totalPages' => \Post::model()->count(
                        'user_id = :user_id',
                        array(':user_id' => $user->getPrimaryKey())
                    ) / 5,
                    'route' => 'post/author',
                    'routeOptions' => array('id' => $id,),
                ),
            )
        );
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
                'actions' => array('new', 'checkSlug', 'edit', 'delete', 'dashboard',),
            ),
            array('allow',),
        );
    }
}
