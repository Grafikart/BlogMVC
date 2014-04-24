<?php
// This is global bootstrap for autoloading
\Codeception\Util\Autoload::registerSuffix('Page', __DIR__.DIRECTORY_SEPARATOR.'_pages');
// this shit sucks
// Yii isn't found by standard composer autoload
require_once dirname(__DIR__).'/boot/testing.php';
require_once __DIR__.'/_helpers/CacheHelper.php';
\Codeception\Module\CacheHelper::init();