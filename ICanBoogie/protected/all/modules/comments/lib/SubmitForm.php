<?php

namespace BlogMVC\Modules\Comments;

use Brickrouge\Button;
use Brickrouge\Form;
use Brickrouge\Element;
use Brickrouge\Text;
use ICanBoogie\Operation;

class SubmitForm extends Form
{
	const POST_ID = "#submit-form-post-id";

	public function __construct(array $attributes=[])
	{
		parent::__construct($attributes + [

			Form::HIDDENS => [

				Operation::DESTINATION => 'comments',
				Operation::NAME => 'submit',

				'post_id' => empty($attributes[self::POST_ID]) ? null : $attributes[self::POST_ID]

			],

			Form::ACTIONS => [

				new Button("Submit", [ 'class' => 'btn-primary', 'type' => 'submit' ])

			],

			Element::CHILDREN => [

				'mail' => new Text([

					Element::REQUIRED => true,
					Element::VALIDATOR => [ 'Brickrouge\Form::validate_email' ],

					'class' => 'form-control',
					'placeholder' => "Your email",
					'type' => 'email'

				]),

				'username' => new Text([

					Element::REQUIRED => true,

					'class' => 'form-control',
					'placeholder' => "Your name",
					'size' => 50

				]),

				'content' => new Element('textarea', [

					Element::REQUIRED => true,

					'class' => 'form-control',
					'placeholder' => "Your comment",
					'rows' => 3

				])

			],

			'name' => 'comments/submit'

		]);
	}

	protected function render_children(array $children)
	{
		return <<<EOT
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			{$children['mail']}
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			{$children['username']}
		</div>
	</div>
</div>

<div class="form-group">
	{$children['content']}
</div>
EOT;
	}
}
