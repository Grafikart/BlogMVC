
	<div class="col-md-8">
		<div class="page-header">
			<h1><?= $post->name ?></h1>
			<p><small>
				Category : <?= HTML::anchor('category/' . $post->category->slug, HTML::chars($post->category->name)) ?>,
				by <?= HTML::anchor('author/' . $post->author->id, HTML::chars($post->author->username)) ?> on <em><?= date("D dS Y", strtotime($post->created)) ?></em>
			</small></p>
		</div>

		<article><?= Markdown::instance()->transform($post->content) ?></article>

		<hr>

		<section id="comments" class="comments">
			<h3>Comment this post</h3>

			<?php if (Session::instance()->get('flash_errors') != NULL):
				$errors =  Session::instance()->get_once('flash_errors') ?>
				<div class="alert alert-danger">
					<h4><strong>Oh snap !</strong> you did some errors</h4>
					<?php foreach ($errors as $error): ?>
						<div><?= $error ?></div>
					<?php endforeach ?>
				</div>
			<?php else:
				$errors = array();
				endif ?>

			<?= Form::open('comment/' . $post->slug , array('method' => 'POST')) ?>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group <?= in_array('mail' , $errors ) ? 'has-error' : '' ?>">
							<?= Form::input('mail', '', array('class' => 'form-control', 'placeholder' => 'Your email')) ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group <?= in_array('username' , $errors ) ? 'has-error' : '' ?>">
							<?= Form::input('username', '', array('class' => 'form-control', 'placeholder' => 'Your username')) ?>
						</div>
					</div>
				</div>
				<div class="form-group <?= in_array('content' , $errors ) ? 'has-error' : '' ?>">
					<?= Form::textarea('content', '', array('class' => 'form-control', 'placeholder' => 'Your comment', 'rows' => 3)) ?>
				</div>
				<div class="form-group">
					<?= Form::submit(NULL , 'Submit', array('type' => 'submit', 'class' => 'btn btn-primary')) ?>
				</div>
			<?= Form::close() ?>

			<?php if ($nb_comments > 0): ?>
				<h3><?= $nb_comments ?> <?= Inflector::plural('comment', $nb_comments) ?></h3>
				<?php foreach($comments as $index => $comment): ?>
					<div class="row">
						<?php if($index > 0) echo '<hr>'  ?>
						<div class="col-md-2">
							<img src="http://lorempicsum.com/futurama/100/100/<?= ($index+1) ?>" width="100%">
						</div>
						<div class="col-md-10">
							<p><strong><?= $comment->username ?></strong> <?= date("D dS Y", strtotime($comment->created)) ?></p>
							<p><?= nl2br(HTML::chars(strip_tags($comment->content))) ?></p>
						</div>
					</div>
				<?php endforeach ?>
			<?php endif ?>
		</section>
	</div>

	<div class="col-md-4 sidebar">
		<?= View::factory('blog/sidebar') ?>
	</div><!-- /.sidebar -->
