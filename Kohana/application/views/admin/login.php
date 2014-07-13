
	<?php if(Session::instance()->get_once('flash_error') != NULL): ?>
		<div class="alert alert-danger">
			<h4><strong>Oh snap !</strong> you forgot your IDs ?</h4>
			<div><?php // Session::instance()->get('flash_error') ?></div> 
		</div>
	<?php endif; ?>

	<?= Form::open('login' ,array( 'class' => 'form-signin', 'method' => 'POST')) ?>
		<h4 class="form-signin-heading">Please sign in</h4>
		<?= Form::input('username', '', array('class' => 'form-control', 'placeholder' => 'Username', 'autofocus' => 'autofocus')) ?>
		<?= Form::password('password', '' , array('class' => 'form-control', 'placeholder' => 'Password')) ?>
		<?= Form::button(NULL , 'Submit', array('type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block')) ?>
	<?= Form::close() ?>