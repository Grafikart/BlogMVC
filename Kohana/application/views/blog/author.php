
	<div class="col-md-8">
		<div class="page-header">
			<h1>Blog</h1>
			<p class="lead"><?= $user->username ?></p>
		</div>

		<?= View::factory('blog/posts')->set('posts' , $posts) ?>

		<?= $posts->render() ?>
	</div>

	<div class="col-md-4 sidebar">
		<?= View::factory('blog/sidebar') ?>
	</div><!-- /.sidebar -->