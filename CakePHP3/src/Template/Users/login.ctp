<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create() ?>
    <?= $this->Form->input('username') ?>
    <?= $this->Form->input('password') ?>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
