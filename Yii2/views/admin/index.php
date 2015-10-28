<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Create Post', ['/post/create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'category_id',
                'label' => 'Category',
                'value' => 'category.name',
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Username',
                'value' => 'user.username',
            ],
            [
                'attribute' => 'name',
                'label' => 'Title',
            ],
            [
                'attribute' => 'created',
                'label' => 'Creation date',
                'format' => ['date', 'php:d-m-y H:i:s'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('view', ['/post/view/', 'slug' => $model->slug], ['class' => 'btn btn-primary']);
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('update', ['/post/update/', 'slug' => $model->slug], ['class' => 'btn btn-primary']);
                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a('delete', ['/post/delete/', 'id' => $model->id], ['class' => 'btn btn-danger']);
                    }
                ]
            ],
        ],
    ]); ?>

</div>
