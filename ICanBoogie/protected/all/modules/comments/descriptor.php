<?php

namespace BlogMVC\Modules\Comments;

use ICanBoogie\Module\Descriptor;
use ICanBoogie\ActiveRecord\Model;

return [

	Descriptor::MODELS => [

		'primary' => [

			Model::SCHEMA => [

				'fields' => [

					'id' => 'serial',
					'post_id' => 'foreign',
					'username' => 'varchar',
					'mail' => 'varchar',
					'content' => [ 'text', 'medium' ],
					'created' => 'datetime'

				]
			]
		]
	],

	Descriptor::NS => __NAMESPACE__,
	Descriptor::TITLE => "Comments"

];
