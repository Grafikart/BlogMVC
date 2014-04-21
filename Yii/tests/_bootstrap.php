<?php
// This is global bootstrap for autoloading
\Codeception\Util\Autoload::registerSuffix('Page', __DIR__.DIRECTORY_SEPARATOR.'_pages');
require_once(__DIR__ . '/_data/YiiBridge/yiit.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii/framework/yiit.php');
if (!class_exists('Yii', false) || Yii::app() === null) {
    $config = include(__DIR__.'/../config/test.php');
    \Yii::createWebApplication($config);
    \Yii::import('application.tests.classes.base.*');
}