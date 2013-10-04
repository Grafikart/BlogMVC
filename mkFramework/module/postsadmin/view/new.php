<?php $oPluginHtml=new plugin_html?>
<form action="" method="POST" >
<input type="hidden" name="formmodule" value="postsadmin" />

<table class="tb_new">
	
	<tr>
		<th>Category</th>
		<td><input name="category_id" /><?php if($this->tMessage and isset($this->tMessage['category_id'])): echo implode(',',$this->tMessage['category_id']); endif;?></td>
	</tr>

	<tr>
		<th>user_id</th>
		<td><input name="user_id" /><?php if($this->tMessage and isset($this->tMessage['user_id'])): echo implode(',',$this->tMessage['user_id']); endif;?></td>
	</tr>

	<tr>
		<th>Name</th>
		<td><input name="name" /><?php if($this->tMessage and isset($this->tMessage['name'])): echo implode(',',$this->tMessage['name']); endif;?></td>
	</tr>

	<tr>
		<th>slug</th>
		<td><input name="slug" /><?php if($this->tMessage and isset($this->tMessage['slug'])): echo implode(',',$this->tMessage['slug']); endif;?></td>
	</tr>

	<tr>
		<th>content</th>
		<td><input name="content" /><?php if($this->tMessage and isset($this->tMessage['content'])): echo implode(',',$this->tMessage['content']); endif;?></td>
	</tr>

	<tr>
		<th>Publication date</th>
		<td><input name="created" /><?php if($this->tMessage and isset($this->tMessage['created'])): echo implode(',',$this->tMessage['created']); endif;?></td>
	</tr>

</table>

<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Ajouter" /> <a href="<?php echo module_postsadmin::getLink('list')?>">Annuler</a>
</form>

