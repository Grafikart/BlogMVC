<?php
// This is global bootstrap for autoloading
\Codeception\Util\Autoload::registerSuffix('Page', __DIR__.DIRECTORY_SEPARATOR.'_pages');
// this shit sucks
// Yii isn't found by standard composer autoload
require_once dirname(__DIR__).'/boot/testing.php';
require_once __DIR__.'/_data/YiiBridge/yiit.php';
launch_codeception_yii_bridge();
require_once __DIR__.'/_support/helpers/CacheHelper.php';
#require_once dirname(__DIR__).'/vendor/codeception/codeception/Platform/RunFailed.php';
\Codeception\Module\CacheHelper::init();