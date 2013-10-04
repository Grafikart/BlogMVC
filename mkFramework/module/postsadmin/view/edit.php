<h1>Edit post</h1>

<p><a href="<?php echo module_postsadmin::getLink('list')?>">< Back to posts</a></p>
            
<?php $oPluginHtml=new plugin_html?>
<form action="#" id="PostAdminEditForm" method="post" accept-charset="utf-8">
<div class="row">
	<div class="col-md-6">
		<div class="form-group required">
			<label for="PostName">Name :</label>
			<input  name="name" value="<?php echo $this->oPosts->name ?>"  class="form-control" maxlength="255" type="text" id="PostName" required="required">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group required">
			<label for="PostSlug">Slug :</label>
			<input name="slug" value="<?php echo $this->oPosts->slug ?>"  class="form-control" maxlength="255" type="text" id="PostSlug" required="required">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="PostCategoryId">Category :</label>
			<?php echo $oPluginHtml->getSelect('category_id',$this->tJoinmodel_categories,null,array('class'=>'form-control','id'=>'PostCategoryId'))?>
			
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="PostUserId">Author :</label>
			<?php echo $oPluginHtml->getSelect('user_id',$this->tJoinmodel_users,null,array('class'=>'form-control','id'=>'PostUserId'))?>
		</div>
	</div>
</div>
<div class="form-group required">
	<label for="PostContent">Content :</label>
	<textarea name="content" class="form-control" cols="30" rows="6" id="PostContent" required="required"><?php echo $this->oPosts->content?></textarea>
</div>
<div class="submit">
	<input class="btn btn-primary" type="submit" value="Edit">
</div>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

</form>

