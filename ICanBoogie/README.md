# BlogMVC / ICanBoogie 2.3.x version

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





## Faster!

ICanBoogie is pretty fast, and believe it or not, it can be faster. Open
"protected/all/config/core.php" and activate caches:

```php
<?php

return [

	'cache configs' => true,
	'cache modules' => true,
	'cache locale' => true

];
```

On a MacBook Pro (Retina, 13-inch, Mid 2014), the overhead (or boot time) of ICanBoogie is about
3 ms. The home page is rendered in ±70 ms, for which 80% is used by Markdown.
