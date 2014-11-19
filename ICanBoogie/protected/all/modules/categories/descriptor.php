<?php

namespace BlogMVC\Modules\Categories;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module\Descriptor;

return [

	Descriptor::MODELS => [

		'primary' => [

			Model::SCHEMA => [

				'fields' => [

					'id' => 'serial',
					'name' => [ 'varchar', 50 ],
					'slug' => [ 'varchar', 50 ],
					'post_count' => [ 'varchar', 50 ]

				]
			]
		]
	],

	Descriptor::NS => __NAMESPACE__,
	Descriptor::TITLE => "Categories"

];
