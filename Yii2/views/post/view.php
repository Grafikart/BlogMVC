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
    <section>
        <p>
            Category: <?php echo Html::a($model->category->name, '#'); ?>, by <?php echo Html::a(ucfirst($model->user->username), '#'); ?> on <?php echo Yii::$app->formatter->asDate($model->created, 'long'); ?>
        </p>
        <p>
            <?php echo Html::decode(nl2br($model->content)); ?>
        </p>
    </section>

    <aside>
        <h2><?php echo count($comments); ?> Commentaires</h2>
        <?php foreach($comments as $comment): ?>
            <article>
                <?php echo Html::decode($comment->username); ?>
                <br>
                <?php echo Html::decode($comment->content); ?>
            </article>
        <?php endforeach; ?>
    </aside>
</div>
