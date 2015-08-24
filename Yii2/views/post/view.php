<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Category: <?php echo Html::a($model->category->name, '#'); ?>, by <?php echo Html::a(ucfirst($model->user->username), '#'); ?> on <?php echo Yii::$app->formatter->asDate($model->created, 'long'); ?>
    </p>
    <p>
        <?php echo Html::decode(nl2br($model->content)); ?>
    </p>

</div>
