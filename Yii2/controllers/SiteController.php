<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Post;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        try {
            Yii::trace('Trace : ' . __METHOD__, __METHOD__);

            //build a DB to get all post
            $query = Post::find();

            //get total number of post (but do not fetch post yet)
            $count = $query->count();

            //create a pagination
            $pagination = new Pagination([
                'totalCount' => $count,
                'pageSize' => 2,
            ]);

            //limit the query using the pagination and fetch articles
            $posts = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

            return $this->render('index', [
                'posts' => $posts,
                'pagination' => $pagination,
            ]);
        } catch(Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    public function actionLogin()
    {
        try {
            Yii:trace('Trace : '.__METHOD__, __METHOD__);

            $response = null;
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $response = $this->redirect(['/admin/post']);
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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
