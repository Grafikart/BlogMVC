<?php

namespace BlogMVC\Modules\Posts;

class Admin extends \Brickrouge\ListView
{
	public function __construct(array $attributes=[])
	{
		parent::__construct($attributes + [

			self::COLUMNS => [

				'id' => [ __CLASS__ . '\KeyColumn', [

					'title' => $this->t("ID")

				] ],

				'name' => [ __CLASS__ . '\NameColumn', [

					'title' => $this->t("Name")

				] ],

				'created' => [ __CLASS__ . '\CreatedColumn', [

					'title' => $this->t("Publication date")

				] ],

				'category' => [ __CLASS__ . '\CategoryColumn', [

					'title' => $this->t("Category")

				] ],

				'actions' => [ __CLASS__ . '\ActionsColumn', [

					'title' => $this->t("Actions")

				] ]

			]

		]);
	}

	protected function render_table(array $decorated_headers, array $rendered_rows)
	{
		return parent::render_table($decorated_headers, $rendered_rows)
		->add_class('table')
		->add_class('table-striped');
	}
}
