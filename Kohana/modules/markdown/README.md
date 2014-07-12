## Kohana Markdown ##
###### *Last edited: Wed, 07 July 2010 (stroppytux)* ######

A text-to-HTML conversion tool for web writers for Kohana 3.

Based off the php created by Michel Fortin under the gpl lisense. For more
information, please refer to:
<http://michelf.com/projects/php-markdown/>

Original Markdown concept by John Gruber. Please refer to:
<http://daringfireball.net/projects/markdown/>

Markdown is a text-to-HTML filter; it translates an easy-to-read /
easy-to-write structured text format into HTML. Markdown's text format
is most similar to that of plain text email, and supports features such
as headers, *emphasis*, code blocks, blockquotes, and links.

Markdown's syntax is designed not as a generic markup language, but
specifically to serve as a front-end to (X)HTML. You can use span-level
HTML tags anywhere in a Markdown document, and you can use block level
HTML tags (like `<div>` and `<table>` as well).

For more information about Markdown's syntax, see:
<http://daringfireball.net/projects/markdown/>

## Installation ##

1. ### Check out the main source ###

	Checkout the main repository from github. In order to do this, you will need
	a github key configured. Please check the github documentation for more
	details.

		git clone git://github.com/stroppytux/kohana-markdown.git modules/markdown


	This should give you the following *(in the modules/markdown directory)*:

		classes  config  README.md

2. ### Configure Markdown ###

	Copy the configuration file located in markdown/config to your application
	configuration directory.

		cp modules/markdown/config/markdown.php application/config/

	* ####type####
		Defines the type of output to produce. This can be one of *html* or *xhtml*.

	* ####tab_width####
		When producing the output, indentation is applied. The **tab_width**
		value sets the tab width to use for the indentation.

3. ### Enable Markdown ###

	In order to enable the markdown module, edit the application/bootstrap.php
	file and add and enable the markdown module within the `Kohana::modules`
	section of the bootstrap file.

		'markdown'		=> MODPATH.'markdown',		// Markdown module

4. ### Process strings ###

	Now add the markdown transformer in between the value received from the
	user, and the storage. eg.

		<?php defined('SYSPATH') or die('No direct script access.');
		
		class Model_Description extends Model {
			
			public function add($data)
			{
				$query = DB::query(Database::INSERT, '
				INSERT INTO `Descriptions`
					(`d_title`, `d_description`)
				VALUES
					(:title, :description)');
				
				/* Sort out the description */
				$description = Markdown::instance()->transform($data['description']);
				
				/* Add the paramaters to the query */
				$query->param(':title', $data['title']);
				$query->param(':description', $description);
				return $query->execute();
			}
		}

5. ### Validation rules ###

	A helper paramater has been added to the Kohana_markdown class that can be
	used in conjunction with the Kohana_Validation class. In order to use this,
	add the following to the validation rules:

		/* Validate the input */
		$validation = Validate::factory(array('description' => $description)
		->rule('description', 'regex', array(Markdown::$validate));

