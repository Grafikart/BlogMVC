<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE') or define('YII_TRACE', 3);
require_once dirname(__DIR__).'/vendor/yiisoft/yii/framework/yii.php';
require_once dirname(__DIR__).'/vendor/autoload.php';
$config = include dirname(__DIR__).'/config/web-test.php';
Yii::createWebApplication($config)->run();
