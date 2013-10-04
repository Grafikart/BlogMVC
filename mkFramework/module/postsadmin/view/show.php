<table class="tb_show">
	
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
<p><a href="<?php echo module_postsadmin::getLink('list')?>">Retour</a></p>

