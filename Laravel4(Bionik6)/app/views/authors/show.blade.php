@extends('layouts.master')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-8">

            <div class="page-header">
                <h1>Blog</h1>
                <p class="lead">Welcome on my blog</p>
            </div>

            @foreach( $posts as $post )
                <article>
                    <h2><a href="{{ URL::to('posts/'.$post->slug) }}">{{ $post->name}}</a></h2>
                    <p>
                        <small>
                            Category :
                            <a href="{{ URL::route('category.show', $post->categorie['slug'])}}">{{ $post->categorie['name']}}</a>,
                            by
                            <a href="{{ URL::route('authors.show', $post->user['id']) }}">{{ $post->user['username']}}</a> on
                            <em>{{ $post->created}}</em>
                        </small>
                    </p>
                    <p>{{ Str::words(Markdown::string($post->content) , 100)}}</p>
                    <p class="text-right">
                        <a href="{{ URL::to('posts/' . $post->slug)}}" class="btn btn-primary">Read more...</a>
                    </p>
                </article>
                <hr>
            @endforeach

            {{ $posts->links() }}

        </div>

        @include('layouts.sidebar')
    </div>

</div><!-- /.container -->

@stop
