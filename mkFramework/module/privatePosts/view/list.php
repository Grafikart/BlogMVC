<h1>Manage posts</h1>

<p><a href="<?php echo _root::getLink('privatePosts::new') ?>" class="btn btn-primary">Add a new post</a></p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Category</th>
			<th>Publication date</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php if($this->tPosts):?>
		<?php foreach($this->tPosts as $oPosts):?>
			<tr>
				<td><?php echo $oPosts->id ?></td>
				<td><?php echo $oPosts->name ?></td>
				<td><?php echo $this->tJoinmodel_categories[$oPosts->category_id];?></td>
				<td><?php echo $oPosts->created ?></td>
				<td>
					<a href="<?php echo _root::getLink('privatePosts::edit',array(
										'id'=>$oPosts->getId()
									) 
							)?>" class="btn btn-primary">Edit</a>
					<a href="<?php echo _root::getLink('privatePosts::delete',array(
										'id'=>$oPosts->getId()
									) 
							)?>" class="btn btn-danger" onclick="return confirm('Are you sure ?')">Delete</a>
				</td>
			</tr>
		<?php endforeach;?>
		<?php endif;?>
		
	</tbody>
</table>

<?php echo $this->oPagination->build()->show()?>

