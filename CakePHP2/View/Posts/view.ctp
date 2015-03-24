<?php $this->set('title_for_layout', $post['Post']['name']); ?>

<div class="row">
    <div class="col-md-8">

        <div class="page-header">
            <h1><?= $post['Post']['name']; ?></h1>
            <p><small>
                Category : <a href="<?= $this->Html->url(array('controller' => 'posts', 'action' => 'index', 'category' => $post['Category']['slug'])); ?>"><?= $post['Category']['name']; ?></a>,
                by <a href="<?= $this->Html->url(array('controller' => 'posts', 'action' => 'index', 'user' => $post['User']['id'])); ?>"><?= $post['User']['username']; ?></a> on <em><?= $this->Time->format('F jS, H:i', $post['Post']['created']); ?></em>
            </small></p>
        </div>

        <article>
            <?= $this->Markdown->parse($post['Post']['content']); ?>
        </article>

        <hr>

        <section class="comments">

            <h3>Comment this post</h3>

            <?= $this->Session->flash(); ?>

            <?= $this->Form->create('Comment', array(
                'inputDefaults' => array(
                        'div'   => array('class' => 'form-group'),
                        'class' => 'form-control',
                        'label' => false
                ),
            )); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $this->Form->input('username', array('placeholder' => 'Your username')); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->input('mail', array('placeholder' => 'Your email')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= $this->Form->input('content', array('placeholder' => 'Your comment', 'type' => 'textarea')); ?>
                </div>
                <?= $this->Form->submit('Submit my comment', array('class' => 'btn btn-primary')); ?>
            <?= $this->Form->end(); ?>

            <hr>

            <h3><?= sprintf(__n('%s comment', '%s Comments', count($post['Comment'])), count($post['Comment'])); ?></h3>

            <?php foreach ($post['Comment'] as $k => $comment): ?>
            <div class="row">
                <div class="col-md-2">
                    <img src="http://1.gravatar.com/avatar/<?= md5($comment['mail']); ?>?s=100" width="100%">
                </div>
                <div class="col-md-10">
                    <p><strong><?= h($comment['username']); ?></strong> <?= $this->Time->timeAgoInWords($comment['created'], array('end' => '1 year')); ?> ago</p>
                    <p><?= nl2br(h($comment['content'])); ?></p>
                </div>
            </div>
            <hr>
            <?php endforeach ?>
        </section>

    </div>

    <?= $this->element('sidebar', array(), array('cache' => 'default')); ?>

</div>