<?php 
$oForm=new plugin_form($this->oPosts);
$oForm->setMessage($this->tMessage);
?>
<h1>Edit post</h1>

<p><a href="<?php echo _root::getLink('privatePosts::list')?>">< Back to posts</a></p>
<form action="" id="PostAdminEditForm" method="post" accept-charset="utf-8">
<input type="hidden" name="formmodule" value="postsadmin"/>
<div class="row">
	<div class="col-md-6">
		<div class="form-group required">
			<label for="PostName">Name :</label>
			<?php echo $oForm->getInputText('name',array('class' => 'form-control' ,'maxlength' => 255, 'id' =>'PostName', 'required' => 'required'));?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group required">
			<label for="PostSlug">Slug :</label>
			<?php echo $oForm->getInputText('slug',array('class' => 'form-control' ,'maxlength' => 255, 'id' =>'PostSlug', 'required' => 'required'));?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="PostCategoryId">Category :</label>
			<?php echo $oForm->getSelect('category_id',$this->tJoinmodel_categories,array('class' => 'form-control' ,'maxlength' => 255, 'id' =>'PostCategoryId'));?>
			
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="PostUserId">Author :</label>
			<?php echo $oForm->getSelect('user_id',$this->tJoinmodel_users,array('class' => 'form-control' ,'maxlength' => 255, 'id' =>'PostUserId'));?>
		</div>
	</div>
</div>
<div class="form-group required">
	<label for="PostContent">Content :</label>
	<?php echo $oForm->getInputTextarea('content',array('class' => 'form-control' ,'cols'=>30,'rows'=>6, 'id' =>'PostContent', 'required' => 'required'));?>
</div>
<div class="submit">
	<input class="btn btn-primary" type="submit" value="Edit">
</div>

<?php echo $oForm->getToken('token',$this->token)?>
</form>

