<?php
use \Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('api', 'ajax');

$I = new ApiGuy($scenario);
$I->wantTo('Ensure ajax comment update works fine');

$I->amOnPage(\BlogFeedPage::$url);
$I->click(\BlogFeedPage::$postTitleSelector);
$postUrl = $I->grabFromCurrentUrl();
$ajaxUrl = $I->grabAttributeFrom(\PostPage::$commentForm, 'data-action-ajax');

$I->sendPOST($ajaxUrl, array(
    \PostPage::$commentTextArea => 'Sample comment',
    \PostPage::$commentUsernameField => 'Fuy Gox',
));
$I->assertTrue($I->grabDataFromJsonResponse('success'));
$I->assertNotEmpty($I->grabDataFromJsonResponse('data'));

$I->sendPOST($ajaxUrl, array(
    \PostPage::$commentTextArea => 'Sample comment',
));
$I->assertFalse($I->grabDataFromJsonResponse('success'));
$I->assertNotEmpty($I->grabDataFromJsonResponse('errors'));

$I->sendPOST($ajaxUrl, array(
    \PostPage::$commentUsernameField => 'Fuy Gox',
));
$I->assertFalse($I->grabDataFromJsonResponse('success'));
$I->assertNotEmpty($I->grabDataFromJsonResponse('errors'));

$I->amOnPage(\LoginPage::$url);
$I->submitForm(\LoginPage::$formSelector, array(
    \LoginPage::$loginField => Fixtures::get('data:users[0]:login'),
    \LoginPage::$passwordField => Fixtures::get('data:users[0]:password'),
));

$I->sendPost($ajaxUrl, array(
    \PostPage::$commentTextArea => 'Sample comment',
));
$I->assertTrue($I->grabDataFromJsonResponse('success'));
$I->assertNotEmpty($I->grabDataFromJsonResponse('data'));
