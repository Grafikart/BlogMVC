<?php
// Here you can initialize variables that will for your tests

\Codeception\Util\Autoload::registerSuffix('Steps', __DIR__.DIRECTORY_SEPARATOR.'_steps');

\Yii::app()->fixtureManager->prepare();

\Yii::app()->cache->flush();

$appModel = new \ApplicationModel;
$appModel->language = \Codeception\Util\Fixtures::get('defaults:app:language');
$appModel->name = \Codeception\Util\Fixtures::get('defaults:app:name');
$appModel->theme = \Codeception\Util\Fixtures::get('defaults:app:theme');
$appModel->save();