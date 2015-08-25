<?php

namespace app\controllers;

use Yii;
use app\models\Comment;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        try {
            Yii::trace('Trace :' . __METHOD__, __METHOD__);

            $model = $this->findModel($id);
            $commentForm = new Comment(['scenario' => 'create']);
            if (($commentForm->load($_POST) === true) && ($commentForm->validate() === true)) {
                $commentForm->created = Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');
                $commentForm->post_id = $id;
                $commentForm->save();
            }

            $comments = $model->getComments()->orderBy('created')->all();

            return $this->render('view', [
                'model' => $model,
                'comments' => $comments,
                'commentForm' => $commentForm,
            ]);
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
