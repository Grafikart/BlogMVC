<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
require_once __DIR__.'/../vendor/yiisoft/yii/framework/yiit.php';
$config = require __DIR__.'/../config/testing.php';
Yii::createWebApplication($config);