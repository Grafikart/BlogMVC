<?php
use \Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('api', 'ajax');

\Yii::app()->fixtureManager->prepare();

$I = new ApiGuy($scenario);
$I->wantTo('Save category via ajax call');

$url = \Yii::app()->createUrl('category/ajaxSave');
$uniqueName = md5(microtime());

$I->assertNull(\Category::model()->findBySlug($uniqueName));
$I->amOnPage(\LoginPage::$url);
$I->submitForm(\LoginPage::$formSelector, array(
    \LoginPage::$loginField => Fixtures::get('data:users[0]:login'),
    \LoginPage::$passwordField => Fixtures::get('data:users[0]:password'),
));
$I->sendPOST($url, array(
    'Category[name]' => $uniqueName,
    'Category[slug]' => $uniqueName,
));
$I->seeResponseCodeIs(200);
$id = $I->grabDataFromJsonResponse('data.id');
$slug = $I->grabDataFromJsonResponse('data.slug');
$I->assertNotNull($category = \Category::model()->findBySlug($uniqueName));
$I->assertEquals($id, $category->id);
$I->assertEquals($slug, $category->slug);

$uniqueName = md5(microtime());
$I->sendPOST($url, array(
    'Category[id]' => $id,
    'Category[name]' => $uniqueName,
    'Category[slug]' => $uniqueName,
));
$I->assertEquals($id, $I->grabDataFromJsonResponse('data.id'));
$I->assertNotNull($category = \Category::model()->findBySlug($uniqueName));
$I->assertEquals($category->id, $I->grabDataFromJsonResponse('data.id'));
$I->assertEquals($uniqueName, $I->grabDataFromJsonResponse('data.slug'));

$I->sendPOST($url, array(
    'Category[name]' => $uniqueName,
    'Category[slug]' => $uniqueName,
));
$I->assertNotEquals($id, $I->grabDataFromJsonResponse('data.id'));
$I->assertEquals($uniqueName.'-1', $I->grabDataFromJsonResponse('data.slug'));

$I->sendPOST($url, array(
    'Category[slug]' => $uniqueName,
));
$I->assertFalse($I->grabDataFromJsonResponse('success'));
$I->assertNotEmpty($I->grabDataFromJsonResponse('errors'));
