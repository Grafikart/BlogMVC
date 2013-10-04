<h4>Last posts</h4>
<div class="list-group">
<?php if($this->tPosts):?>
	<?php foreach($this->tPosts as $oPosts):?>
		<a href="<?php echo module_posts::getLink('show',array('id'=>$oPosts->id))?>" class="list-group-item">
			<?php echo $oPosts->name?>
		</a>
	<?php endforeach;?>
<?php endif;?>
</div>
