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
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
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
            $text = Yii::t('templates', 'breadcrumbs.pageTitle', array(
                '{pageNumber}' => $this->pageNumber,
            ));
            $this->breadcrumbs = array(
                Yii::app()->request->requestUri => $text,
            );
        }
    }
    /**
     * Method for alteration breadcrumbs for edit page.
     * 
     * @param Post $post Current post instance.
     * @return void
     * @since 0.1.0
     */
    public function alterEditBreadcrumbs(Post $post)
    {
        array_pop($this->breadcrumbs);
        $this->breadcrumbs[Yii::app()->request->requestUri] = $post->name;
    }
    /**
     * Main action, renders last 5 posts from the feed.
     * 
     * @throws CHttpException Raises HTTP error 402 if unknown format is
     * requested.
     * @throws CHttpException Raises HTTP error 404 if requested feed page
     * doesn't exist (except for the first page).
     * 
     * @param int|string $page Page number in string form.
     * @param string $format Format to supply page in.
     * @return void
     * @since 0.1.0
     */
    public function actionIndex($page=1, $format='html')
    {
        $this->setPage($page, Yii::t('templates', 'blog.pageTitle'));
         $format = strtolower($format);
        if ($format !== 'html' && !\DataFormatter::knownFormat($format)) {
            throw new \HttpException(400, 'badRequest.invalidFormat');
        }
        $posts = Post::model()->paged($this->pageNumber)->with('author')->findAll();
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
        }
        else {
            echo Yii::app()->formatter->formatModels($posts, $format);
        }
    }
    /**
     * Shows selected post in chosen format.
     *
     * @throws \HttpException Thrown if requested post doesn't exist or can't be
     * formatted using provided format.
     *
     * @param string $slug Post slug.
     * @param string $format Format to render post in.
     * @since 0.1.0
     */
    public function actionShow($slug, $format='html')
    {
        $post = \Post::model()->with('comments')->find('slug = :slug', array(
            ':slug' => $slug,
        ));
        $comment = new \Comment;
        if (\Yii::app()->user->hasData('comment')) {
            $comment->setAndValidate(\Yii::app()->user->getData('comment'));
        }
        if ($post === null) {
            throw new \HttpException(404);
        }
        if ($format === 'html') {
            $this->render('show', array(
                'post' => $post,
                'comment' => $comment,
            ));
        } else if (!\DataFormatter::knownFormat($format)) {
            throw new \HttpException(400, 'badRequest.invalidFormat');
        } else {
            echo \Yii::app()->formatter->formatModel('post', $format);
        }
    }
    public function actionNew()
    {
        $post = new Post;
        if (($data = Yii::app()->request->getPost('Post', false)) &&
                $post->setAndSave($data)) {
            Yii::app()->user->sendMessage('post.submit.success');
            $this->redirect(array('post/show', 'slug' => $post->slug));
        }
        $this->render('form', array(
            'post' => $post,
            'categories' => Category::model()->getList()
        ));
    }
    public function actionCheckSlug($slug)
    {
        if (!Yii::app()->request->isAjaxRequest && YII_DEBUG == false) {
            $message = Yii::t('http-errors', 'badRequest.ajaxOnly');
            throw new CHttpException(402, $message);
        }
        echo CJSON::encode(Post::model()->slugExists($slug));
    }
    public function actionEdit($id)
    {
        $model = \Post::model()->findByPk($id);
        if ($model === null) {
            throw new \HttpException(404);
        } else if ((int) $model->user_id !== Yii::app()->user->id) {
            throw new \HttpException(403, 'notAuthorized.postOwnership');
        }
        if ($data = Yii::app()->request->getPost('Post')) {
            $model->setAndSave($data);
        }
        $this->pageTitle = $model->name;
        $this->alterEditBreadcrumbs($model);
        $this->render('form', array(
            'post' => $model,
            'categories' => \Category::model()->getList(),
        ));
    }
    public function actionDelete($id)
    {
        if (($model = \Post::model()->findByPk($id)) === null) {
            throw new \HttpException(404);
        }
        if ((int)$model->user_id !== Yii::app()->user->id) {
            $message = \Yii::t('http-errors', 'notAuthorized.postOwnership');
            throw new \HttpException(403, $message);
        }
        $model->delete();
        \Yii::app()->user->sendMessage('post.delete.success', array(
            '{title}' => $model->name,
        ));
        $this->redirect(array('post/dashboard'));
    }
    public function actionDashboard($page=1)
    {
        $page = (int) $page;
        if ($page < 1) {
            throw new \CHttpException(404);
        }
        $posts = Post::model()->paged($page, 10)->findAll();
        if (empty($posts) && $page !== 1) {
            throw new \CHttpException(404);
        }
        $this->render('dashboard', array(
            'posts' => $posts,
            'pagination' => array(
                'currentPage' => $page,
                'totalPages' => Post::model()->totalPages(10),
                'route' => 'post/dashboard',
            ),
        ));
    }
    public function filters()
    {
        return array('accessControl');
    }
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
