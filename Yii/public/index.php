<?php
// disable 'r' get parameter
require(dirname(dirname(__FILE__)).'/vendor/yiisoft/yii/framework/yii.php');
$config = dirname(dirname(__FILE__)).'/config/front.php';
Yii::createWebApplication($config)->run();