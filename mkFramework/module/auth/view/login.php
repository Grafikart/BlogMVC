 <form class="form-signin" action="" method="POST">
	<h4 class="form-signin-heading">Please sign in</h4>
	<input name="login" autocomplete="off" type="text" class="form-control" placeholder="Email address" autofocus>
	<input name="password"  type="password" class="form-control" placeholder="Password">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

	<?php if($this->sError!=''):?>
		<p style="color:red"><?php echo $this->sError?></p>
	<?php endif;?>
