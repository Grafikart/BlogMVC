<?php

namespace BlogMVC\Modules\Users;

use ICanBoogie\Operation;

use Brickrouge\Button;
use Brickrouge\Element;
use Brickrouge\Form;
use Brickrouge\Text;

class SignInForm extends Form
{
	public function __construct(array $attributes=[])
	{
		parent::__construct($attributes + [

			Form::ACTIONS => [

				new Button("Sign in", [

					'class' => "btn-primary btn-lg btn-block",
					'type' => 'submit'

				])

			],

			Form::HIDDENS => [

				Operation::DESTINATION => 'users',
				Operation::NAME => 'sign-in'

			],

			Element::CHILDREN => [

				new Element('h4', [

					Element::INNER_HTML => "Please sign in",

					'class' => "form-signin-heading"

				]),

				'username' => new Text([

					Element::REQUIRED => true,

					'autofocus' => true,
					'class' => 'form-control',
					'placeholder' => 'User name'

				]),

				'password' => new Text([

					Element::REQUIRED => true,

					'class' => 'form-control',
					'placeholder' => 'Password',
					'type' => 'password'

				])

			],

			'class' => 'form-signin',
			'name' => 'users/signin'

		]);
	}
}
