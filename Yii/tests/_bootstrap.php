<?php
use \Codeception\Util\Fixtures;
// no utf without this
setlocale(LC_ALL, 'en_US.UTF8');

// This is global bootstrap for autoloading
\Codeception\Util\Autoload::registerSuffix('Page', __DIR__.DIRECTORY_SEPARATOR.'_pages');
// this shit sucks
// Yii isn't found by standard composer autoload
require_once dirname(__DIR__).'/boot/testing-console.php';
require_once __DIR__.'/_data/YiiBridge/yiit.php';
launch_codeception_yii_bridge();
#require_once dirname(__DIR__).'/vendor/codeception/codeception/Platform/RunFailed.php';


$serverName = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : false;
$dbFixtures = \Yii::app()->fixtureManager->getFixtures();
$users = include $dbFixtures['users'];
$posts = include $dbFixtures['posts'];
$categories = include $dbFixtures['categories'];

$index = 0;
// fixture uses associative array naming, so i can't iterate with usual for
foreach ($users as $user) {
    //Fixtures::add("data:users[$index]", $user);
    Fixtures::add("data:users[$index]:login", $user['username']);
    Fixtures::add("data:users[$index]:password", $user['rawPassword']);
    $index++;
}
Fixtures::add('data:users:length', $index);

$index = 0;
foreach ($posts as $post) {
    //Fixtures::add("data:posts[$index]", $post);
    Fixtures::add("data:posts[$index]:title", $post['name']);
    Fixtures::add("data:posts[$index]:content", $post['content']);
    Fixtures::add("data:posts[$index]:slug", $post['slug']);
    Fixtures::add("data:posts[$index]:created", $post['created']);
    Fixtures::add("data:posts[$index]:author", $post['user_id']);
    Fixtures::add("data:posts[$index]:category", $post['category_id']);
    $index++;
}
Fixtures::add('data:posts:length', $index);

$index = 0;
foreach ($categories as $category) {
    Fixtures::add("data:categories[$index]:title", $category['name']);
    Fixtures::add("data:categories[$index]:slug", $category['slug']);
}
Fixtures::add('data:categories:length', $index);

Fixtures::add('data:random:int', mt_rand(0, PHP_INT_MAX));
Fixtures::add('data:random:string', md5(Fixtures::get('data:random:int')));

Fixtures::add('defaults:app:language', \Yii::app()->language);
Fixtures::add('defaults:app:name', \Yii::app()->name);
Fixtures::add('defaults:app:theme', \Yii::app()->theme->name);
Fixtures::add('defaults:server:host', $serverName);
