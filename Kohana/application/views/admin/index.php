
	<h1>Manage posts</h1>

	<p><?= HTML::anchor('admin/create', 'Add a new post', array('class' => 'btn btn-primary')) ?></p>

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
			<?php foreach ($posts as $post): ?>
				<tr>
					<td><?= $post->id ?></td>
					<td><?= HTML::chars($post->name) ?></td>
					<td><?= HTML::chars($post->category->name) ?></td>
					<td><?= date("d/m/Y H:i", strtotime($post->created)) ?></td>
					<td>
						<?= HTML::anchor('admin/edit/' . $post->slug, 'Edit',array('class' => 'btn btn-primary')) ?>
						<?= HTML::anchor('admin/delete/' . $post->slug, 'Delete', array('class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Are you sure ?\')')) ?>
					</td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>

	<?= $posts->render() ?>
