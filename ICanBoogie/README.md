# BlogMVC / ICanBoogie 2.x version

Greetings! This is a [ICanBoogie](https://github.com/ICanBoogie/ICanBoogie)-based BlogMVC realization.





## Installation

1. Install vendors with `composer install`.
2. Import the SQL dump of the project ("dump.sql") in a new database.
3. Configure your database connection with the file "protected/all/activerecord.php".
4. The "repository" directory must be writable by PHP. `chmod 0777 repository -R` is not ideal
but should do the trick.
5. Enjoy!





## Running

You can configure a vhost to test the application, or simply run PHP internal server:

```
$ cd /path/to/BlogMVC/ICanBoogie
$ php -S localhost:8000
```
