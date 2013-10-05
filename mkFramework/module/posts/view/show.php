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
						
						

<table class="tb_show">
	
	<tr>
		<th>category_id</th>
		<td><?php echo $this->tJoinmodel_categories[$this->oPosts->category_id]?></td>
	</tr>

	<tr>
		<th>user_id</th>
		<td><?php echo $this->tJoinmodel_users[$this->oPosts->user_id]?></td>
	</tr>

	<tr>
		<th>name</th>
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
		<th>created</th>
		<td><?php echo $this->oPosts->created ?></td>
	</tr>

</table>
<p><a href="<?php echo module_posts::getLink('list')?>">Retour</a></p>

