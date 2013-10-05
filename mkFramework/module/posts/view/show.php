<div class="page-header">
	<h1><?php echo $this->oPosts->name ?></h1>
	<p><small>
	Category : <a href="category.html"><?php echo $this->tJoinmodel_categories[$this->oPosts->category_id]?></a>,
	by <a href="index.html"><?php echo $this->tJoinmodel_users[$this->oPosts->user_id]?><</a> on <em><?php echo $this->oPosts->created ?></em>
	</small></p>
</div>

<article>
	<?php echo plugin_markdown::tr($this->oPosts->content) ?>
</article>

<hr>

<section class="comments">
	
<?php echo $this->oCommentsAdd->show()?>

<?php echo $this->oComments->show()?>

</section>
