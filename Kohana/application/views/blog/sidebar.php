<h4>Categories</h4>
<div class="list-group">
	<?php foreach ($sidebar_categories as $category): ?>
		<?= html_entity_decode(HTML::anchor('category/' . $category->slug, '<span class="badge">'.$category->post_count.'</span> '.HTML::chars($category->name), array('class' => 'list-group-item'))) ?>
	<?php endforeach ?>
</div>

<h4>Last posts</h4>
<div class="list-group">
	<?php foreach ($sidebar_posts as $post): ?>
		<?= HTML::anchor('post/' . $post->slug, HTML::chars($post->name), array('class' => 'list-group-item')) ?>
	<?php endforeach ?>
</div>