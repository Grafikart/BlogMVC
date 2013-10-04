
 <div class="page-header">
	<h1>Blog</h1>
	<p class="lead">Welcome on my blog</p>
</div>
 <?php if($this->tPosts):?>
	<?php foreach($this->tPosts as $oPosts):?>
		 <article>
			<h2><a href="post.html"><?php echo $oPosts->name ?></a></h2>
			<p><small>
				Category : <a href="category.html"><?php if(isset($this->tJoinmodel_categories[$oPosts->category_id])){ echo $this->tJoinmodel_categories[$oPosts->category_id];}else{ echo $oPosts->category_id ;}?></a>,
				by <a href="index.html"><?php echo $this->tJoinmodel_users[$oPosts->user_id];?></a> on <em><?php echo $oPosts->created ?></em>
			</small></p>
			<p><?php echo substr(trim(plugin_markdown::tr($oPosts->content)),0,190) ?>...</p>
			<p class="text-right"><a href="<?php echo module_posts::getLink('show',array('id'=>$oPosts->id))?>" class="btn btn-primary">Read more...</a></p>
		</article>
	<?php endforeach;?>
<?php endif;?>


<?php echo $this->oPagination->build()->show()?>

