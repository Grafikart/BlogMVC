<h4>Categories</h4>
<div class="list-group">
	@foreach ($sidebar_categories as $category)
		{{ HTML::decode(HTML::linkRoute('category', '<span class="badge">'.$category->post_count.'</span> '.e($category->name), array($category->slug), array('class' => 'list-group-item'))) }}
	@endforeach
</div>

<h4>Last posts</h4>
<div class="list-group">
	@foreach ($sidebar_posts as $post)
		{{ HTML::linkRoute('post', e($post->name), array($post->slug), array('class' => 'list-group-item')) }}
	@endforeach
</div>