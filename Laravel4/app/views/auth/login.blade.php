@extends('layouts.blog')

@section('title')
Login
@stop

@section('content')
	@if (Session::has('flash_error'))
		<div class="alert alert-danger">
			<h4><strong>Oh snap !</strong> you forgot your IDs ?</h4>
			<div>{{ Session::get('flash_error') }}</div>
		</div>
	@endif

	{{ Form::open(array('route' => array('login.post'), 'class' => 'form-signin', 'role' => 'form')) }}
		<h4 class="form-signin-heading">Please sign in</h4>
		{{ Form::text('username', '', array('class' => 'form-control', 'placeholder' => 'Username', 'autofocus' => 'autofocus')) }}
		{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
		{{ Form::button('Submit', array('type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block')) }}
	{{ Form::close() }}
@stop