<h1>Edit post</h1>

<p><a href="<?= $this->Html->url(array('action' => 'index')); ?>">< Back to posts</a></p>

<?= $this->Form->create('Post', array(
    'inputDefaults' => array(
            'div'   => array('class' => 'form-group'),
            'class' => 'form-control'
    )
)); ?>
    <?= $this->Form->input('id'); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $this->Form->input('name', array('label' => "Name :")); ?>
        </div>
        <div class="col-md-6">
            <?= $this->Form->input('slug', array('label' => "Slug :")); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $this->Form->input('category_id', array('label' => "Category :")); ?>
        </div>
        <div class="col-md-6">
            <?= $this->Form->input('user_id', array('label' => "Author :")); ?>
        </div>
    </div>
    <?= $this->Form->input('content', array('label' => "Content :")); ?>
    <?= $this->Form->submit('Edit', array('class' => 'btn btn-primary')); ?>
<?= $this->Form->end(); ?>
