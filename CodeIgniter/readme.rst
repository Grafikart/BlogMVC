*******************
Installation
*******************
CodeIgniter's source code isn't embedded with composer right now due to lack of support from CI's team. So all the source code from https://github.com/bcit-ci/CodeIgniter is already in the repo.

-  Create database and dump sql file.

-  Change database settings in application/config/database.php
-  Change global config in application/config/config.php
-  Change routes config in application/config/routes.php

All the settings are preconfigured to load the app via that url : yourhost/BlogMVC/CodeIgniter/, if you want to change it you will have to change base_url value in the global config file + the htacess file who has some rewrite rules.

Enjoy ;)

*******************
Server Requirements
*******************

-  PHP version 5.2.4 or newer.

###################
About CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.



