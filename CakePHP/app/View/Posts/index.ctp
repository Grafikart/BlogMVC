<?php $this->set('title_for_layout', 'Blog'); ?>

<div class="row">
    <div class="col-md-8">
        <div class="page-header">
            <h1>Blog</h1>
            <p class="lead">Welcome on my blog</p>
        </div>

        <?php foreach ($posts as $k => $post): ?>
        <article>
            <h2><a href="<?= $this->Html->url($post['Post']['url']); ?>" title="<?= $post['Post']['name']; ?>"><?= $post['Post']['name']; ?></a></h2>
            <p><small>
                Category : <a href="<?= $this->Html->url(array('controller' => 'posts', 'action' => 'index', 'category' => $post['Category']['slug'])); ?>"><?= $post['Category']['name']; ?></a>,
                by <a href="<?= $this->Html->url(array('controller' => 'posts', 'action' => 'index', 'user' => $post['User']['id'])); ?>"><?= $post['User']['username']; ?></a> on <em><?= $this->Time->format('F jS, H:i', $post['Post']['created']); ?></em>
            </small></p>
            <p><?= $this->Text->truncate(strip_tags($post['Post']['content']), 450); ?></p>
            <p class="text-right">
                <a href="<?= $this->Html->url($post['Post']['url']); ?>" title="<?= $post['Post']['name']; ?>" class="btn btn-primary">Read more...</a>
            </p>
        </article>
        <hr>
        <?php endforeach ?>

        <ul class="pagination">
        <?php
            echo $this->Paginator->prev(__('Previous'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
            echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
            echo $this->Paginator->next(__('Next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
        ?>
        </ul>

    </div>
    <?= $this->element('sidebar', array(), array('cache' => 'default')); ?>
</div>
