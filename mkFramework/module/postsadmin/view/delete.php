<table class="tb_delete">
	
	<tr>
		<th>Category</th>
		<td><?php echo $this->oPosts->category_id ?></td>
	</tr>

	<tr>
		<th>user_id</th>
		<td><?php echo $this->oPosts->user_id ?></td>
	</tr>

	<tr>
		<th>Name</th>
		<td><?php echo $this->oPosts->name ?></td>
	</tr>

	<tr>
		<th>slug</th>
		<td><?php echo $this->oPosts->slug ?></td>
	</tr>

	<tr>
		<th>content</th>
		<td><?php echo $this->oPosts->content ?></td>
	</tr>

	<tr>
		<th>Publication date</th>
		<td><?php echo $this->oPosts->created ?></td>
	</tr>

</table>

<form action="" method="POST">
<input type="hidden" name="formmodule" value="postsadmin" />
<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo module_postsadmin::getLink('list')?>">Annuler</a>
</form>

