@extends('layouts.blog')

@section('content')
	<h1>Add a new post</h1>

	<p>{{ HTML::linkRoute('admin', '< Back to posts') }}</p>

	@if (count($errors->all()) > 0)
		<div class="alert alert-danger">
			<h4><strong>Oh snap !</strong> you did some errors</h4>
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
	@endif

	{{ Form::open(array('route' => 'admin.create.post', 'role' => 'form')) }}
		<div class="row">
			<div class="col-md-6">
				<div class="form-group required">
					{{ Form::label('name', 'Name :') }}
					{{ Form::text('name', '', array('class' => 'form-control', 'required' => 'required')) }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group required">
					{{ Form::label('slug', 'Slug :') }}
					{{ Form::text('slug', '', array('class' => 'form-control', 'required' => 'required')) }}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					{{ Form::label('category_id', 'Category :') }}
					{{ Form::select('category_id', $categories, '', array('class' => 'form-control')) }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					{{ Form::label('user_id', 'Author :') }}
					{{ Form::select('user_id', $authors, '', array('class' => 'form-control')) }}
				</div>
			</div>
		</div>
		<div class="form-group required">
			{{ Form::label('content', 'Content :') }}
			{{ Form::textarea('content', '', array('class' => 'form-control', 'cols' => 30, 'rows' => 6, 'required' => 'required')) }}
		</div>
		<div class="submit">
			{{ Form::button('Add', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	{{ Form::close() }}
@stop