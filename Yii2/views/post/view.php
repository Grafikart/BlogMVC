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
        <h2>Add Comment</h2>
        <?php if ($commentForm->hasErrors() === true): ?>
            <div class="alert alert-danger">
                <?php echo Html::errorSummary($commentForm); ?>
            </div>
        <?php endif; ?>

        <?php echo Html::beginForm(['/comment/create', 'postId', $model->id], 'post', ['role' => 'form']); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Html::activeTextInput($commentForm, 'mail', ['placeholder' => 'Your email', 'class' => 'form-control']);?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Html::activeTextInput($commentForm, 'username', ['placeholder' => 'Your username', 'class' => 'form-control']);?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo Html::activeTextArea($commentForm, 'content', ['placeholder' => 'Your comment', 'class' => 'form-control']);?>
                </div>
            <div class="form-group">
                <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']);?>
            </div>
        <?php echo Html::endForm(); ?>

        <h3><?php echo count($comments); ?> Commentaires</h3>
        <?php foreach($comments as $comment): ?>
            <article>
                <?php echo Html::decode($comment->username); ?>
                <br>
                <?php echo Html::decode($comment->content); ?>
            </article>
        <?php endforeach; ?>
    </aside>
</div>
