<?php $this->assign('title', 'Blog'); ?>

<div class="row">
    <div class="col-md-8">
        <div class="page-header">
            <h1>Blog</h1>
            <p class="lead">Welcome on my blog</p>
        </div>

        <?php foreach ($posts as $post): ?>
            <article>
                <h2><?= $this->Html->link($post->name, $post->url); ?></h2>
                <p>
                    <small>
                        Category : <?= $this->Html->link($post->category->name, $post->category->url); ?>
                    </small>
                </p>
                <p>
                    <?= $this->Text->truncate(strip_tags($post->content), 450); ?>
                </p>
                <p class="text-right">
                    <?= $this->Html->link("Read more...", $post->url, ['class' => 'btn btn-primary', 'title' => $post->name]); ?>
                </p>
            </article>
            <hr>
        <?php endforeach ?>
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>

    </div>

    <?= $this->cell('Sidebar::display'); ?>

</div>