<?php

namespace app\controllers;

use app\models\Post;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * AdminController implements the CRUD actions for Post model.
 */
class AdminController extends Controller
{
    public $defaultAction = 'login';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'login', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function($rule, $action) {
                            return $this->redirect(['login']);
                        }
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function($rule, $action) {
                            return $this->redirect(['index']);
                        }
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * Lists all Post models with CRUD actions
     *
     * @return mixed
     */
    public function actionIndex()
    {
        try {
            Yii::trace('Trace : '.__METHOD__, __METHOD__);

            $dataProvider = new ActiveDataProvider([
                'query' => Post::find(),
                'pagination' => [
                    'pageSize' => Yii::$app->params['pagination'],
                ]
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } catch(Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }

    }

    /**
     * log the user in B.O
     *
     * @return null|string|\yii\web\Response
     * @throws Exception
     * @throws \Exception
     */
    public function actionLogin()
    {
        try {
            Yii::trace('Trace : '.__METHOD__, __METHOD__);

            $response = null;
            $model = new User(['scenario' => 'login']);
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $response = $this->redirect(['/admin/index']);
            }

            if ($response === null) {
                $response = $this->render('login', [
                    'model' => $model,
                ]);
            }

            return $response;
        } catch(Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    /**
     * logout the user
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
