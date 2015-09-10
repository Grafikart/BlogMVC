<?php

namespace app\controllers;

use app\models\Post;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * display all posts
     *
     * @return string
     * @throws Exception
     * @throws \Exception
     */
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
                'pageSize' => Yii::$app->params['pagination'],
            ]);

            //limit the query using the pagination and fetch articles
            $posts = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->orderBy('id DESC')
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
}
