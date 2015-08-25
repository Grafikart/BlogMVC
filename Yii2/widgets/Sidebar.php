<?php

namespace app\widgets;

use app\models\Post;
use app\models\Category;
use yii\base\Widget;

class Sidebar extends Widget
{
    public $categories;
    public $posts;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->posts = Post::find()->orderBy('created')->limit(10)->all();
        $this->categories = Category::find()->limit(5)->all();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('sidebar', [
           'posts' => $this->posts,
            'categories' => $this->categories,
        ]);
    }
}