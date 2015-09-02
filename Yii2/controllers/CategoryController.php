<?php

namespace app\controllers;

use app\models\Category;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class CategoryController extends Controller
{
    public $defaultAction = 'posts';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * get post from a user
     *
     * @param $id
     * @return string
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionPosts($slug)
    {
        try {
            Yii::trace('Trace in :'.__METHOD__, __METHOD__);

            $model = Category::find()->where(['slug' => $slug])->one();
            if ($model === null) {
                throw new NotFoundHttpException('The requested post does not exist.');
            }
            $query = $model->getPosts();
            $count = $query->count();
            $pagination = new Pagination([
                'totalCount' => $count,
                'pageSize' => Yii::$app->params['pagination'],
            ]);

            $posts = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->orderBy('created DESC')
                ->all();

            return $this->render('posts', [
                'posts' => $posts,
                'pagination' => $pagination,
            ]);
        } catch(\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }

    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
