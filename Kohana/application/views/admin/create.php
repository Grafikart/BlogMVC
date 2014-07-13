
	<h1>Add a new post</h1>

	<p><?= HTML::anchor('admin', '< Back to posts') ?></p>

	<?php if(Session::instance()->get('flash_errors') != NULL): ?>
		<div class="alert alert-danger">
			<h4><strong>Oh snap !</strong> you did some errors</h4>
			<?php Session::instance()->get_once('flash_errors')
			//foreach(Session::instance()->get_once('flash_errors') as $error): ?>
				<div><?php // $error ?></div>
			<?php //endforeach ?>
		</div>
	<?php endif ?>

	<?= Form::open('admin/create' , array('method' => 'POST')) ?>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group required">
					<?= Form::label('name', 'Name :') ?>
					<?= Form::input('name', '', array('class' => 'form-control', 'required' => 'required' , 'id' => 'name')) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group required">
					<?= Form::label('slug', 'Slug :') ?>
					<?= Form::input('slug', '', array('class' => 'form-control', 'required' => 'required' , 'id' => 'slug')) ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<?= Form::label('category_id', 'Category :') ?>
					<?= Form::select('category_id', $categories, NULL, array('class' => 'form-control' , 'id' => 'category_id')) ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<?= Form::label('user_id', 'Author :') ?>
					<?= Form::select('user_id', $authors, NULL, array('class' => 'form-control' , 'id' => 'user_id')) ?>
				</div>
			</div>
		</div>
		<div class="form-group required">
			<?= Form::label('content', 'Content :') ?>
			<?= Form::textarea('content', '', array('id' => 'content' , 'class' => 'form-control', 'cols' => 30, 'rows' => 6, 'required' => 'required')) ?>
		</div>
		<div class="submit">
			<?= Form::submit(NULL , 'Add', array('type' => 'submit', 'class' => 'btn btn-primary')) ?>
		</div>
	<?= Form::close() ?>