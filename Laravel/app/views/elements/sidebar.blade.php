<div class="col-md-4 sidebar">

    <h4>Categories</h4>
    <div class="list-group">
        @foreach (Category::all() as $category)
            <a href="{{ URL::action('PostsController@category', $category->slug) }}" class="list-group-item">
                <span class="badge">{{ $category->post_count }}</span>
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <h4>Last posts</h4>
    <div class="list-group">
        @foreach (Post::limit(2)->get() as $post)
        <a href="{{ $post->url }}" class="list-group-item">
            {{ $post->name }}
        </a>
        @endforeach
    </div>
</div><!-- /.sidebar -->