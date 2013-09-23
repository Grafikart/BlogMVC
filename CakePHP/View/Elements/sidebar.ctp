<?php extract($this->requestAction(array('controller' => 'posts', 'action' => 'sidebar'))); ?>

<div class="col-md-4 sidebar">

    <h4>Categories</h4>
    <div class="list-group">
        <?php foreach($categories as $category): ?>
        <a href="<?= $this->Html->url(array('controller' => 'posts', 'action' => 'index', 'category' => $category['Category']['slug'])); ?>" class="list-group-item">
            <span class="badge"><?= $category['Category']['post_count']; ?></span>
            <?= $category['Category']['name']; ?>
        </a>
        <?php endforeach; ?>
    </div>

    <h4>Last posts</h4>
    <div class="list-group">
    <?php foreach($last_posts as $post): ?>
        <a href="<?= $this->Html->url($post['Post']['url']); ?>" class="list-group-item">
            <?= $post['Post']['name']; ?>
        </a>
    <?php endforeach; ?>
    </div>
</div><!-- /.sidebar -->