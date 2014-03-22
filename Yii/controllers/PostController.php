<?php

/**
 * This controller handles basic CRUD work posts.
 * If you're not familiar with MVC system, please note that controller
 * actions should be much more thin than the ones you can find here. Fat
 * actions are the first sign of bad architecture and non-reusable code. The
 * only reason i didn't i clean it up is that i didn't have enough time.
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
     * Current page number.
     * 
     * @var int
     * @since 0.1.0
     */
    protected $page;
    /**
     * Initialization function.
     * 
     * @return void
     * @since 0.1.0
     */
    public function init()
    {
        $this->page = max(1, (int)Yii::app()->request->getParam('page'));
    }
    /**
     * Standard breadcrumbs generator
     * 
     * @return void
     * @since 0.1.0
     */
    public function generateBreadcrumbs() {
        if ($this->page > 1) {
            $text = Yii::t('templates', 'breadcrumbs.pageTitle', array(
                '{pageNumber}' => $this->page,
            ));
            $this->breadcrumbs = array(
                Yii::app()->request->requestUri => $text,
            );
        }
    }

    public function actionIndex($page=1, $format='html')
    {
        $page = max((int) $page, 1);
        $format = strtolower($format);
        if ($format !== 'html' && !DataFormatter::knownFormat($format)) {
            throw new CHttpException(402);
        }
        $this->pageTitle = Yii::app()->name;
        $posts = Post::model()->recently($page)->with('author')->findAll();
        if ($page > 1 && sizeof($posts) === 0) {
            throw new CHttpException(404);
        }
        if ($format === 'html') {
            $data = array(
                'posts' => $posts,
                'pagination' => array(
                    'currentPage' => $page,
                    'totalPages' => Post::model()->totalPages(),
                    'route' => 'post/index',
                ),
            );
            $this->render('index', $data);
        }
        else {
            echo Yii::app()->formatter->formatModels($posts, $format);
        }
    }
    public function actionShow($slug, $format='html')
    {
        $model = Post::model()->with('comments')->find('slug = :slug', array(
            ':slug' => $slug,
        ));
        $commentModel = Comment::model();
        if ($data = Yii::app()->request->getPost('Comment', false)) {
            $commentModel->post_id = $model->id;
            if ($commentModel->setAndSave($data)) {
                Yii::app()->user->sendMessage('comment.submit.success');
            } else {
                Yii::app()->user->sendMessage('comment.submit.fail');
            }
        }
        // if old commentModel was used, it would contain already submitted data
        $this->render('show', array('post' => $model, 'commentModel' => Comment::model()));
    }
    public function actionEdit($slug)
    {
        $model = Post::model()->findByAttributes();
        $this->render('form', array('post' => $model));
    }
    public function actionDelete($id)
    {
        $model = Post::model()->findByPk($id);
        if ($model->user_id !== Yii::app()->user->id) {
            throw new CHttpException(403);
        }
        $model->delete();
        Yii::app()->user->sendMessage('post.afterDelete');
        $this->redirect('post/admin');
    }
    public function actionDashboard($page=1)
    {
        
    }
}
