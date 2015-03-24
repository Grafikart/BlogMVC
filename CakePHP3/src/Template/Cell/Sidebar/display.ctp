<div class="col-md-4 sidebar">

    <h4>Categories</h4>
    <div class="list-group">
        <?php foreach($categories as $category): ?>
            <a href="<?= $this->Url->build($category->url); ?>" class="list-group-item">
                <span class="badge"><?= $category->post_count; ?></span>
                <?= $category->name; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <h4>Last posts</h4>
    <div class="list-group">
        <?php foreach($posts as $post): ?>
            <a href="<?= $this->Url->build($post->url); ?>" class="list-group-item">
                <?= $post->name; ?>
            </a>
        <?php endforeach; ?>
    </div>
</div><!-- /.sidebar -->