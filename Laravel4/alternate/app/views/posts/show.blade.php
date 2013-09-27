@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="page-header">
                <h1>The Route of All Evil</h1>
                <p>
                    <small>
                        Category :
                        <a href="{{ URL::route('category.show', $post->categorie['slug']) }}">{{ $post->categorie['name'] }}</a>,
                        by
                        <a href="{{ URL::route('authors.show', $post->user['id']) }}">{{ $post->user['username'] }}</a> on
                        <em>{{ $post->created }}</em>
                    </small>
                </p>
            </div>

            <article>
                {{ Markdown::string($post->content) }}
            </article>

            <hr>

            <section class="comments">

                <h3>Comment this post</h3>

                @if(Session::has('alert_error'))
                <div class="alert alert-danger">
                    <strong>{{ Session::get('alert_error') }}</strong>
                </div>
                @endif
                {{ Form::open(["route" => "comments.store"]) }}
                {{ Form::hidden("post_id", $post->id) }}
                <div class="row">
                    <div class="col-md-6">
                        @if($errors->has('email'))
                        <div class="form-group has-error">
                            <input type="email" class="form-control" name="email" value="{{ Input::old('email') }}" placeholder="Your email">
                            {{ $errors->first('email') }}
                        </div>
                        @else
                        <div class="form-group">
                            <input type="email" name="email" value="{{ Input::old('email') }}" class="form-control" placeholder="Your email">
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($errors->has('username'))
                        <div class="form-group has-error">
                            <input type="text" class="form-control" name="username" value="{{ Input::old('username') }}" id="exampleInputEmail1" placeholder="Your username">
                            {{ $errors->first('username') }}
                        </div>
                        @else
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Your username">
                        </div>
                        @endif
                    </div>
                </div>
                @if($errors->has('content'))
                <div class="form-group has-error">
                    <textarea name="content" class="form-control" rows="3" placeholder="Your comment">{{ Input::old('content') }}</textarea>
                    {{ $errors->first('content') }}
                </div>
                @else
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="3" placeholder="Your comment"></textarea>
                </div>
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                {{ Form::close() }}

                @if( count($comments) > 0)
                <h3> {{ count($comments) }} {{ str_plural("Comment", count($comments)) }} </h3>
                @foreach($comments as $comment)
                <div class="row">
                    <div class="col-md-2">
                        <img src="http://lorempicsum.com/futurama/255/200/5" width="100%">
                    </div>
                    <div class="col-md-10">
                        <p>
                            <strong>{{ $comment->username }}</strong> 10 hours ago
                        </p>
                        <p> {{ $comment->content }} </p>
                    </div>
                </div>
                @endforeach
                @else
                <h3>No comments</h3>
                @endif
            </section>
        </div>

        @include('layouts.sidebar')

    </div>

</div><!-- /.container -->
@stop
