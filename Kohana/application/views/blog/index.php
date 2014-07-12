

	<div class="col-md-8">
		<div class="page-header">
			<h1>Blog</h1>
			<p class="lead">Welcome on my blog</p>
		</div>

		<?= View::factory('blog/posts') ?>

		<?php //{{ $posts->links() }} ?>
	</div>

	<div class="col-md-4 sidebar">
		<?= View::factory('blog/sidebar') ?>
	</div><!-- /.sidebar -->