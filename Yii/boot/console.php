<?php
/** @todo create proper environment-driven booting */
$appRoot = dirname(dirname(__FILE__));
require $appRoot . '/vendor/yiisoft/yii/framework/yii.php';
$config = require $appRoot . '/config/console.php';
if (getenv('PHP_ENV') && getenv('PHP_ENV') === 'testing') {
    $config['components']['db'] = require $appRoot . '/config/db-test.php';
}
Yii::createConsoleApplication($config)->run();
