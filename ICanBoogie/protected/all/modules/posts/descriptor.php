<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\Module\Descriptor;
use ICanBoogie\ActiveRecord\Model;

return [

	Descriptor::MODELS => [

		'primary' => [

			Model::BELONGS_TO => [

				[ 'categories', [ 'local_key' => 'category_id', 'foreign_key' => 'id' ] ],
				[ 'users', [ 'local_key' => 'user_id', 'foreign_key' => 'id' ] ]

			],

			Model::HAS_MANY => [

				[ 'comments', [ 'local_key' => 'id', 'foreign_key' => 'post_id' ] ]

			],

			Model::SCHEMA => [

				'fields' => [

					'id' => 'serial',
					'category_id' => [ 'foreign', 'indexed' => true/*'fk_posts_categories_idx'*/ ],
					'user_id' => [ 'foreign', 'indexed' => true/*'fk_posts_users1_idx'*/ ],
					'name' => 'varchar',
					'slug' => 'varchar',
					'content' => [ 'text', 'long' ],
					'created' => 'datetime'

				]
			]
		]
	],

	Descriptor::NS => __NAMESPACE__,
	Descriptor::TITLE => 'Posts',
	Descriptor::REQUIRES => [ 'category' ]

];
