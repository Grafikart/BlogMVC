# BlogMVC / Yii 1.x version

Greetings! This is a Yii-based [BlogMVC](http://blogmvc.com) realization.

### Installation

1. Dump Yii folder anywhere on your web server and `cd`' into it
2. [Get composer](http://getcomposer.org)
3. Run `php composer.phar install --no-dev`
4. Setup your database connection in `config/db.php`
5. Run `php boot/console migrate up` and press `y` all the way. You can also add
`--interactive=0` to auto-confirm prompts.
6. Point your web server to the `public/index.php` file (there are prepared
configuration file templates in `config` directory).
7. Have fun! Password-login pair is **admin**/**admin**, go ahead and change it.
8. Optionally you can add some meta tags in `/views/chunks/meta.twig`.

### Installation in detail

1. Download contents of Yii folder of BlogMVC repo in any way you like -
usually, it's "Download ZIP" button on the right on
[github](https://github.com/Grafikart/BlogMVC).
2. After that, you need to get a dependency manager to download Twig. Twig is a
separate package, and it would be uncool just to put it inside repository or
make you download and install it as extension. So, you need to
[get composer](http://getcomposer.org). It doesn't really matter how do you
install and call it (i love putting it in `/usr/local/composer` symlinking to
 `/usr/local/bin/composer`), you just need it on the system to call the
 `install` command, which will automatically fetch Twig.
3. As said above, just call composer from command line using `install` command.
If you won't specify `--no-dev` option, you will download some extra packages as
well. That won't do anything extra except for wasting some time - those packages
are required for testing.
4. Now you need to connect the application to the database. To do this, you need
to describe connection details in `install-dir/config/db.php` file. It can't be
described in couple of words, but i've left some examples in `config/templates`
dir, also you can refer to
[this](http://www.yiiframework.com/doc/guide/1.1/en/database.dao#establishing-database-connection)
article to learn how to do it.
5. The last step in preparing the application is creating it's internal storage
structure and populating it with data. Usually it is separated in two steps, but
i've cheated, so all you need to do is to run migrations. This is done via
calling the application from console: `php boot/console migrate up`:
`php boot/console` invokes the application, `migrate` tells application to call
migration module, and `up` tells that migrations should populate the database.
6. The last step of whole operation is to connect application with web server.
Again, this topic is too big to describe every possible server here, but, as
with database, you can find configuration templates in `config/templates`
folder or refer to
[another Yii documentation article](http://www.yiiframework.com/doc/guide/1.1/en/quickstart.apache-nginx-config).
7. You should be done by now, try accessing application from your browser.

### Requirements

1. PHP 5.3+
2. [Composer](http://getcomposer.org)
3. MySQL, PostgreSQL or SQLite. Oracle and MS SQL Server may work as well, but i
didn't have a chance to test.
4. Any web server that can into PHP

### Requirements-dev

1. [PHPCI](https://www.phptesting.org)
2. [Selenium](http://seleniumhq.org) and any selenium-supported browser
([phantomjs](http://phantomjs.org/) for speedy tests, firefox or
[chrome](https://code.google.com/p/selenium/wiki/ChromeDriver) for fancy
action).
3. [Codeception](http://codeception.com) (fetched via composer).

### Thanks section

I want to devote my quarter-of-minute-of-fame to
[codeception](http://codeception.com), [phpci](https://www.phptesting.org),
[phptest.club](http://phptest.club) (hey, this place really needs more people),
[hashcode.ru](http://hashcode.ru) and [askdev.ru](http://askdev.ru) (beware of
russian stackoverflows), [digital ocean](https://www.digitalocean.com) and
[redmine](http://redmine.org).