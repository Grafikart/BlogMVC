@extends('layouts.blog')

@section('title')
{{{ $post->name }}}
@stop

@section('content')
	<div class="col-md-8">
		<div class="page-header">
			<h1>{{{ $post->name }}}</h1>
			<p><small>
				Category : {{ HTML::linkRoute('category', e($post->category->name), array($post->category->slug)) }},
				by {{ HTML::linkRoute('author', e($post->author->username), array($post->author->id)) }} on <em>{{ date("D dS Y", $post->created_at->timestamp) }}</em>
			</small></p>
		</div>

		<article>{{ Markdown::string($post->content) }}</article>

		<hr>

		<section id="comments" class="comments">
			<h3>Comment this post</h3>

			@if (count($errors->all()) > 0)
				<div class="alert alert-danger">
					<h4><strong>Oh snap !</strong> you did some errors</h4>
					@foreach ($errors->all() as $error)
						<div>{{ $error }}</div>
					@endforeach
				</div>
			@endif

			{{ Form::open(array('route' => array('comment.post', $post->slug), 'role' => 'form')) }}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
							{{ Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'Your email')) }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group {{ ($errors->first('username')) ? 'has-error' : '' }}">
							{{ Form::text('username', '', array('class' => 'form-control', 'placeholder' => 'Your username')) }}
						</div>
					</div>
				</div>
				<div class="form-group {{ ($errors->first('content')) ? 'has-error' : '' }}">
					{{ Form::textarea('content', '', array('class' => 'form-control', 'placeholder' => 'Your comment', 'rows' => 3)) }}
				</div>
				<div class="form-group">
					{{ Form::button('Submit', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
				</div>
			{{ Form::close() }}

			@if ($nb_comments > 0)
				<h3>{{ $nb_comments }} {{ str_plural('Comment', $nb_comments) }}</h3>

				@foreach ($comments as $index => $comment)
					<div class="row">
						@if ($index > 0)
							<hr>
						@endif
						<div class="col-md-2">
							<img src="http://lorempicsum.com/futurama/100/100/{{ ($index+1) }}" width="100%">
						</div>
						<div class="col-md-10">
							<p><strong>{{{ $comment->username }}}</strong> {{ Carbon\Carbon::createFromTimeStamp($comment->created_at->timestamp)->diffForHumans() }}</p>
							<p>{{ nl2br(e(strip_tags($comment->content))) }}</p>
						</div>
					</div>
				@endforeach
			@endif
		</section>
	</div>

	<div class="col-md-4 sidebar">
		@include('blog.sidebar')
	</div><!-- /.sidebar -->
@stop