<?php

namespace BlogMVC\Modules\Posts;

use ICanBoogie\Operation;

use Brickrouge\Button;
use Brickrouge\ColumnedGroup;
use Brickrouge\Element;
use Brickrouge\Form;
use Brickrouge\Group;
use Brickrouge\Text;

class EditForm extends Form
{
	public function __construct(array $attribute=[])
	{
		parent::__construct($attribute + [

			Form::ACTIONS => [

				new Button("Edit", [ 'class' => 'btn-primary', 'type' => 'submit' ])

			],

			Form::HIDDENS => [

				Operation::DESTINATION => 'posts',
				Operation::NAME => 'save'

			],

			Form::RENDERER => "Group",

			Element::GROUPS => [

				'primary' => [

					Element::WEIGHT => 'bottom',

					'class' => 'form-group'

				],

				'row1' => new ColumnedGroup([

					ColumnedGroup::COLUMNS => 2,

					'class' => 'form-group'

				]),

				'row2' => new ColumnedGroup([

					ColumnedGroup::COLUMNS => 2,

					'class' => 'form-group'

				])

			],

			Element::CHILDREN => [

				'name' => new Text([

					Group::LABEL => "Name",
					Element::REQUIRED => true,
					Element::GROUP => 'row1',

					'class' => 'form-control'

				]),

				'slug' => new Text([

					Group::LABEL => "Slug",
					Element::GROUP => 'row1',

					'class' => 'form-control'

				]),

				'category_id' => new Element('select', [

					Group::LABEL => "Category",
					Element::OPTIONS => [ null => '' ] + $this->app->models['categories']->select('id, name')->order('name')->pairs,
					Element::REQUIRED => true,
					Element::GROUP => 'row2',

					'class' => 'form-control'

				]),

				'user_id' => new Element('select', [

					Group::LABEL => "Author",
					Element::OPTIONS => [ null => '' ] + $this->app->models['users']->select('id, username')->order('username')->pairs,
					Element::REQUIRED => true,
					Element::GROUP => 'row2',

					'class' => 'form-control'

				]),

				'content' => new Element('textarea', [

					Group::LABEL => "Content",
					Element::REQUIRED => true,

					'class' => 'form-control'

				])

			]

		]);
	}

	public function offsetSet($attribute, $value)
	{
		if ($attribute == self::VALUES)
		{
			$this->hiddens[Operation::KEY] = empty($value['id']) ? null : $value['id'];
		}

		parent::offsetSet($attribute, $value);
	}
}
