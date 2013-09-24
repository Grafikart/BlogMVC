## blogMVC | Laravel 4 by @thujohn

This subproject is part of the [project](https://github.com/Grafikart/BlogMVC) started by @Grafikart


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
2. Create a new database (for me blogmvc)
3. Open /bootstrap/start.php and define your local environment
-> L31 ```'local' => array('*.local'),``` Modify '*.local' by your machine name, your IP, part of your domain name...
4. Open /app/config/local/database.php
-> Update your infos
5. Open /app/config/local/app.php
-> Update the url
6. Run ```php composer.phar install``` or ```composer install```
7. Run ```php artisan migrate```
8. Run ```php artisan db:seed```
9. Enjoy !