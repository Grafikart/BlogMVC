<?php

namespace app\widgets;

use app\models\Post;
use app\models\Category;
use yii\base\Widget;
use Yii;

class Sidebar extends Widget
{
    public $data;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $cache = Yii::$app->cache;
        $sidebarCacheName = isset(Yii::$app->params['cache']['sidebar']) ? Yii::$app->params['cache']['sidebar'] : null;
        if ($sidebarCacheName !== null) {
            $this->data = $cache->get($sidebarCacheName);
            if ($this->data === false) {
                $this->data['posts'] = Post::find()->orderBy('created')->limit(Yii::$app->params['pagination'])->orderBy('id DESC')->all();
                $this->data['categories'] = Category::find()->limit(Yii::$app->params['pagination'])->all();
                $cache->set($sidebarCacheName, $this->data);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('sidebar', [
            'data' => $this->data,
        ]);
    }
}