# BlogMVC | Laravel 4

## Contributors

* [thujohn](https://github.com/thujohn)

### Laravel PHP Framework

[Laravel](http://laravel.com) is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laravel aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

Documentation for the entire framework can be found on the [Laravel website](http://laravel.com/docs).


### Requirements

PHP >= 5.3.7
MCrypt PHP Extension


### Installation

1. Create a new Virtual Host (for me blogmvc.local) on /public
2. Create a new database (for me blogmvc_laravel)
3. Open /app/config/local/database.php
-> Update your infos
4. Open /app/config/local/app.php
-> Update the url
5. Run ```php composer.phar install``` or ```composer install```
6. Run ```php artisan migrate```
7. Run ```php artisan db:seed```
8. Enjoy !