<?php
$appRoot = dirname(__DIR__);
require $appRoot.'/vendor/yiisoft/yii/framework/yii.php';
require $appRoot.'/vendor/autoload.php';
$config = include $appRoot.'/config/web.php';
Yii::createWebApplication($config)->run();