<?php

namespace BlogMVC\Modules\Posts;

return [

	'facets' => [

		'posts' => [

			'author' => __NAMESPACE__ . '\AuthorCriterion',
			'category' => __NAMESPACE__ . '\CategoryCriterion',
			'created' => __NAMESPACE__ . '\CreatedCriterion',
			'slug' => __NAMESPACE__ . '\SlugCriterion'

		]
	]
];
