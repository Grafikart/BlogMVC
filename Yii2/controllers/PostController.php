<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Post;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * create a post
     *
     * @return null|string|\yii\web\Response
     * @throws Exception
     * @throws \Exception
     */
    public function actionCreate()
    {
        try {
            Yii::trace('Trace :' . __METHOD__, __METHOD__);

            $response = null;
            $model = new Post(['scenario' => 'create']);
            $query = (new Query())->select('name, id')->from('categories')->all();
            $categories = ArrayHelper::map($query, 'id', 'name');
            if (($model->load($_POST) === true) && ($model->validate() === true)) {
                $model->category_id = (int)$model->category_name;
                $model->created = Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');
                $model->user_id = Yii::$app->user->id;
                $status = $model->save();
                if ($status === true) {
                    $sidebarCacheName = isset(Yii::$app->params['cache']['sidebar']) ? Yii::$app->params['cache']['sidebar'] : null;
                    if ($sidebarCacheName !== null) {
                        Yii::$app->cache->delete($sidebarCacheName);
                    }
                    $response = $this->redirect(['/post/view', 'id' => $model->id]);
                }
            }

            if ($response === null) {
                $response = $this->render('create', [
                    'model' => $model,
                    'categories' => $categories,
                ]);
            }
            return $response;
        } catch(Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * Displays a single Post model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        try {
            Yii::trace('Trace :' . __METHOD__, __METHOD__);

            $response = null;
            $model = $this->findModel($id);
            $commentForm = new Comment(['scenario' => 'create']);
            if (($commentForm->load($_POST) === true) && ($commentForm->validate() === true)) {
                $commentForm->created = Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');
                $commentForm->post_id = $id;
                if ($commentForm->save() === true) {
                    $response = $this->redirect(['/post/view', 'id' => $id]);
                }
            }
            //get all comments
            $comments = $model->getComments()->orderBy('created DESC')->all();

            if ($response === null) {
                $response = $this->render('view', [
                    'model' => $model,
                    'comments' => $comments,
                    'commentForm' => $commentForm,
                ]);
            }
            return $response;
        } catch(Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * delete post
     *
     * @param $id
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        try {
            Yii::trace('Trace :' . __METHOD__, __METHOD__);

            $model = $this->findModel($id);
            Comment::deleteAll('post_id = '.$id);

            if ($model->delete() === false) {
                throw new \Exception('Erreur durant la suppression');
            }
            $sidebarCacheName = isset(Yii::$app->params['cache']['sidebar']) ? Yii::$app->params['cache']['sidebar'] : null;
            if ($sidebarCacheName !== null) {
                Yii::$app->cache->delete($sidebarCacheName);
            }

            return $this->redirect(['/post/index']);
        } catch(Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
