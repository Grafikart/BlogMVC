<?php

define('Brickrouge\ACCESSIBLE_ASSETS', __DIR__ . DIRECTORY_SEPARATOR . 'repository' . DIRECTORY_SEPARATOR . 'brickrouge' . DIRECTORY_SEPARATOR);

require "vendor/autoload.php";

$app = \ICanBoogie\boot();
$app();
