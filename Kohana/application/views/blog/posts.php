<?php foreach($posts as $post): ?>
	<article>
		<h2><?= HTML::anchor('post/' . $post->slug, HTML::chars($post->name)) ?></h2>
		<p><small>
			Category : <?= HTML::anchor('category/' . $post->category->slug, HTML::chars($post->category->name)) ?>,
			by <?= HTML::anchor('author/' . $post->author->id , HTML::chars($post->author->username)) ?> 
				on <em><?= date("D dS Y", strtotime($post->created)) ?></em>
		</small></p>
		<p><?= Text::limit_chars(HTML::chars(strip_tags(Markdown::instance()->transform($post->content))), 450) ?></p>
		<p class="text-right"><?= HTML::anchor('post/' . $post->slug, 'Read more...', array('class' => 'btn btn-primary')) ?></p>
	</article>
	<hr>
<?php endforeach ?>