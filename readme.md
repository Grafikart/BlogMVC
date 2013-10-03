# Helping you select a MVC Framework

These days there are plenty of Frameworks that can be used to create your server side code. CakePHP, Symfony 2, Laravel, CodeIgniter, Zend, Ruby On Rails... The list keeps growing and it's not easy to make a choice on what language or what framework to choose.

The goal of this project is to demonstrate how every frameworks works with a simple example : a Blog App.

## Getting Involved

Unfortunately I don't know how to work with every frameworks (impossibru !) so I need you to create the Blog App using your framework of choice (not necessary PHP Framework, you can use ruby, python, java...).

You have to create a blog app using the HTML samples inside the HTML directory : [HTML demo](https://rawgithub.com/Grafikart/blogmvc/master/HTML/index.html). The app is quite simple, you can manage posts, browse posts, and submit new comments (the goal is not to create a fully featured blog, but just a sample of code)

### Database structure

You have to use the same structure as [dump.sql](https://raw.github.com/Grafikart/blogmvc/master/dump.sql). You can rename table and fields depending of your Framework conventions and you can even use migrations if your framework support it.

* categories (belongsTo **Post**)
	* id
	* name
	* slug (used for url rewrite)
	* post_count (count post associated with it)
* comments (belongsTo **Post**)
	* id
	* post_id
	* username  (not empty validation)
	* mail 		(email validation)
	* content 	(not empty validation)
	* created   (date)
* posts (belongsTo **Category**, belongsTo **User**, hasMany **Comments**)
	* id
	* category_id
	* user_id
	* name		(not empty validation)
	* slug 		(can be empty, then slug is generated from name)
	* content	(not empty validation)
	* created
* users (hasMany **Posts**, used for authentification)
	* id
	* username
	* password

### Routing

With great power, comes great routing ! (No seriously don't make the SEO guy angry)

* /   					The homepage with blog posts
* /category/{slug}    	Posts from a category
* /author/{id}			Posts from an author
* /{slug}				Single
* /admin				Backend entry point
* /....?page=2 			Pagination using query parameters


### Additional rules

* code for php >= 5.4 (it means you can use <?= !)
* Post content is written using Markdown, you have to include a plugin (homemade or not) to convert this Markdown into HTML. (It's used to show how plugin work within each framework).
* You have to login to access to the backend. The login is "admin" and the password is "admin" (use the users table to manage user).
* Pagination is limited to 5 posts.
* Posts and Comments are ordered this way : the newer first.
* Data has to be validated before saving (for Post and Comments, see the *database structure* section), there is no "antispam" for the comment submission.
* The blog has a sidebar that is the same for every page and you have to cache it (the cache has to be deleted when a post is saved/deleted)
* Finally you have to create a readme.md to explain how to setup your framework and the requirements.