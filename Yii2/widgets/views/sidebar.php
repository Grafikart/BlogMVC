<?php
use yii\helpers\Html;
?>

<h4>Categories</h4>
<div class="list-group">
    <?php
        foreach($categories as $category):
            echo Html::a(
                $category->name
                .Html::tag('span', $category->getPosts()->count(), ['class' => 'badge']),
                $category->id,
                ['class' => 'list-group-item']
            );
        endforeach;
    ?>
</div>
<h4>Last posts</h4>
<div class="list-group">
    <?php
    foreach($posts as $post):
        echo Html::a(
            $post->name,
            $post->id,
            ['class' => 'list-group-item']
        );
    endforeach;
    ?>
</div>