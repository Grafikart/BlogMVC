<?php
$appRoot = dirname(__FILE__);
require($appRoot.'/vendor/yiisoft/yii/framework/yii.php');
$config = $appRoot.'/config/console.php';
Yii::createConsoleApplication($config)->run();