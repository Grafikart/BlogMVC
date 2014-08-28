@section('title', 'Blog' . (isset($_GET['page']) ? ", page {$_GET['page']}" : "" ));

<div class="row">
    <div class="col-md-8">


        <div class="page-header">
            <h1>@yield('title')</h1>
            <p class="lead">Welcome on my blog</p>
        </div>

        @foreach ($posts as $post)

            <article>
                <h2><a href="{{ $post->url }}">{{ $post->name }}</a></h2>
                <p><small>
                    Category : <a href="{{ $post->category->url }}">{{ $post->category->name }}</a>,
                    by <a href="{{ $post->author_url }}">{{ $post->user->username }}</a> on <em>{{ $post->created_at->format('F jS, H:i') }}</em>
                </small></p>
                <p>{{ Str::words($post->content, 60) }}</p>
                <p class="text-right"><a href="{{ $post->url }}" class="btn btn-primary">Read more...</a></p>
            </article>

            <hr>

        @endforeach

        {{ $posts->links() }}

    </div>

    @cacheinclude('elements.sidebar', 'sidebar')

</div>