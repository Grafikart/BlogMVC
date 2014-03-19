#FuelPHP

* Version: 1.7
* [Website](http://fuelphp.com/)
* [Release Documentation](http://docs.fuelphp.com)
* [Release API browser](http://api.fuelphp.com)
* [Development branch Documentation](http://dev-docs.fuelphp.com)
* [Development branch API browser](http://dev-api.fuelphp.com)
* [Support Forum](http://fuelphp.com/forums) for comments, discussion and community support

## Description

FuelPHP is a fast, lightweight PHP 5.3 framework. In an age where frameworks are a dime a dozen, We believe that FuelPHP will stand out in the crowd.  It will do this by combining all the things you love about the great frameworks out there, while getting rid of the bad.

## More information

For more detailed information, see the [development wiki](https://github.com/fuelphp/fuelphp/wiki).

## Note

* The idea comes from the project [BlogMVC](https://github.com/Grafikart/BlogMVC)
* FuelPHP-BlogMVC is a very simple blog application with FuelPHP
* No SQL dump file was needed, defaults data are added by migrations files
* Admin login : admin/admin

## Install

1. Clone the repo with all submodules : `git clone --recursive http://github.com/jhuriez/fuelphp-blogMVC.git`
2. Edit config db in fuel/app/config/development and fuel/app/config/production
3. Open console
5. Run `curl get.fuelphp.com/oil | sh` for use "oil" instead "php oil"
6. Run `php composer.phar self-update`
7. Run `php composer.phar update`
8. Run `oil refine migrate --all` for load migration files
9. Enjoy !

## Features

* Usage of ORM Model and relationship
* Usage of SimpleAuth for Authentification
* Usage of Cache class and HMVC Request for the sidebar
* Usage of Pagination class
* Usage of Fieldset class for form (post and comment)
* Usage of Router class for all links
* Usage of Theme class
* Usage of Markdown class
* Usage of translation files
* Usage of migration files
