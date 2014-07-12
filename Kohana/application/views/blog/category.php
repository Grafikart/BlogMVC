
	<div class="col-md-8">
		<div class="page-header">
			<h1>Blog</h1>
			<p class="lead"><?= $category->name ?></p>
		</div>

		<?= View::factory('blog/posts')->set('posts' , $posts) ?>

		<?php //$posts->links() ?>
	</div>

	<div class="col-md-4 sidebar">
		<?= View::factory('blog/sidebar') ?>
	</div><!-- /.sidebar -->