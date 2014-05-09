<h1>Manage posts</h1>

<p><?= $this->Html->link('Add a new post', array('action' => 'edit'), array('class' => 'btn btn-primary')); ?></p>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Categorie</th>
            <th>Publication date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <td><?= $post['Post']['id']; ?></td>
            <td><?= $post['Post']['name']; ?></td>
            <td><?= $post['Category']['name']; ?></td>
            <td><?= $this->Time->i18nFormat($post['Post']['created'], '%m/%d/%Y %H:%M'); ?></td>
            <td>
                <a href="<?= $this->Html->url(array('action' => 'edit', $post['Post']['id'])); ?>" class="btn btn-primary">Edit</a>
                <a href="<?= $this->Html->url(array('action' => 'delete', $post['Post']['id'])); ?>" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<ul class="pagination">
<?php
    echo $this->Paginator->prev(__('Previous'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
    echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
    echo $this->Paginator->next(__('Next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
?>
</ul>
