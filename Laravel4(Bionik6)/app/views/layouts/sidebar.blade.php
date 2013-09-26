<div class="col-md-4 sidebar">

    <h4>Categories</h4>
    <div class="list-group">
        @foreach ( $sidebar_categories as $cat )
            <a href="{{ URL::route('category.show', $cat->slug) }}" class="list-group-item">
                <span class="badge">{{ $cat->post_count }}</span>
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <h4>Last posts</h4>
    <div class="list-group">
       @foreach ( $sidebar_posts as $last_post )
            <a href="{{ URL::route('posts.show', $last_post->slug) }}" class="list-group-item">
                {{ $last_post->name }}
            </a>
        @endforeach
    </div>
</div>
<!-- /.sidebar -->
