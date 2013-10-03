@foreach ($posts as $post)
	<article>
		<h2>{{ HTML::linkRoute('post', e($post->name), array($post->slug)) }}</h2>
		<p><small>
			Category : {{ HTML::linkRoute('category', e($post->category->name), array($post->category->slug)) }},
			by {{ HTML::linkRoute('author', e($post->author->username), array($post->author->id)) }} on <em>{{ date("D dS Y", $post->created_at->timestamp) }}</em>
		</small></p>
		<p>{{ Str::limit(e(strip_tags(Markdown::string($post->content))), 450) }}</p>
		<p class="text-right">{{ HTML::linkRoute('post', 'Read more...', array($post->slug), array('class' => 'btn btn-primary')) }}</p>
	</article>
	<hr>
@endforeach