
 <div class="page-header">
	<h1>Blog</h1>
	<p class="lead">Welcome on my blog</p>
</div>
 <?php if($this->tPosts):?>
	<?php foreach($this->tPosts as $oPosts):?>
		 <article>
			<h2><a href="post.html"><?php echo $oPosts->name ?></a></h2>
			<p><small>
				Category : <a href="<?php echo _root::getLink('default::category',array('id'=>$oPosts->category_id))?>"><?php if(isset($this->tJoinmodel_categories[$oPosts->category_id])){ echo $this->tJoinmodel_categories[$oPosts->category_id];}else{ echo $oPosts->category_id ;}?></a>,
				by <a href="<?php echo _root::getLink('default::index')?>"><?php echo $this->tJoinmodel_users[$oPosts->user_id];?></a> on <em><?php $oDate=new plugin_datetime($oPosts->created); echo $oDate->toString('D dS Y'); ?></em>
			</small></p>
			<p><?php echo substr(trim(plugin_markdown::tr($oPosts->content)),0,190) ?>...</p>
			<p class="text-right"><a href="<?php echo module_posts::getLink('show',array('slug'=>$oPosts->slug))?>" class="btn btn-primary">Read more...</a></p>
		</article>
	<?php endforeach;?>
<?php endif;?>


<?php echo $this->oPagination->build()->show()?>

