<?php
$appRoot = dirname(dirname(__FILE__));
require $appRoot.'/vendor/yiisoft/yii/framework/yii.php';
$config = require $appRoot.'/config/console.php';
Yii::createConsoleApplication($config)->run();