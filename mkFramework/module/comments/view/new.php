<h3>Comment this post</h3>
<?php $oPluginHtml=new plugin_html?>

<?php if($this->tMessage and isset($this->tMessage['token'])):?>
	<div class="alert alert-danger"><?php echo $this->tMessage['token']; ?></div>
<?php endif;?>

<form action="" method="POST" >
<input type="hidden" name="formmodule" value="comments" />

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<input name="mail"  type="email" class="form-control" placeholder="Your email">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group has-error">
				<input name="username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Your username">
			</div>
		</div>
	</div>
	<div class="form-group">
		<textarea name="content" class="form-control" rows="3" placeholder="Your comment"></textarea>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
	
	<input type="hidden" name="token" value="<?php echo $this->token?>" />

</form>






