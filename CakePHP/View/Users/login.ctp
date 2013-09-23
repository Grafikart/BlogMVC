<?php $this->set('title_for_layout',"Login"); ?>

<?= $this->Form->create('User', array(
    'inputDefaults' => array(
            'div'   => array('class' => 'form-group'),
            'class' => 'form-control'
    ),
    'class' => 'form-signin',
    'label' => false
)); ?>
    <h4 class="form-signin-heading">Please sign in</h4>
    <?= $this->Form->input('username', array('placeholder' => 'Username')); ?>
    <?= $this->Form->input('password', array('placeholder' => 'Password')); ?>
    <?= $this->Form->submit('Sign in', array('class' => 'btn btn-primary')); ?>
<?= $this->Form->end(); ?>

<?= $this->element('sql_dump'); ?>