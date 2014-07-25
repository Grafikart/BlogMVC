<?php
use \Codeception\Util\Autoload;
// no utf without this
setlocale(LC_ALL, 'en_US.UTF8');

// This is global bootstrap for autoloading
$ds = DIRECTORY_SEPARATOR;
Autoload::registerSuffix('Page', implode($ds, array(__DIR__, '_pages')));
Autoload::registerSuffix('Helper', implode($ds, array(__DIR__, '_support', 'helpers')));
// this shit sucks
// Yii isn't found by standard composer autoload
require_once dirname(__DIR__).'/boot/testing-console.php';
require_once __DIR__.'/_data/YiiBridge/yiit.php';
launch_codeception_yii_bridge();
#require_once dirname(__DIR__).'/vendor/codeception/codeception/Platform/RunFailed.php';

$helper = new \Codeception\Module\BootstrapHelper;
$helper->bootstrap();
