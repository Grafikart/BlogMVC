# BlogMVC / Yii 2.X version

### Installation
1. [Get composer](http://getcomposer.org)
2. Run (if never done before) composer global require "fxp/composer-asset-plugin:1.0.0"
3. Run composer create-project --prefer-dist yiisoft/yii2-app-basic basic
4. Check your have the requirements running the following commands
cd basic
php requirements.php
5. Create your db
6. Set up your database connection in `config/db.php` according to it
7. Run ./yii migrate
8. Make sure `runtime` and `public/assets` directories are writable.
9. localhost/basic/web or whatever is your local
