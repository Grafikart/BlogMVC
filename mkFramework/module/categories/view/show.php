<table class="tb_show">
	
	<tr>
		<th>name</th>
		<td><?php echo $this->oCategories->name ?></td>
	</tr>

	<tr>
		<th>slug</th>
		<td><?php echo $this->oCategories->slug ?></td>
	</tr>

	<tr>
		<th>post_count</th>
		<td><?php echo $this->oCategories->post_count ?></td>
	</tr>

</table>
<p><a href="<?php echo module_categories::getLink('list')?>">Retour</a></p>

