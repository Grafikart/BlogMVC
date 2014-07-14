<?php
/** @type \Codeception\Scenario $scenario */
$scenario->groups(array('frontend', 'profile', 'settings'));

$I = new WebGuy\MemberSteps($scenario);
$I->am('A person who doesn\'t like his own nickname');
$I->wantTo('Change my nickname');
$I->amGoingTo('Leave some comments and change nickname');
$I->expectTo('See that nickname is updated in comments as well');

$I->autoLogin();

$I->amOnPage(\BlogFeedPage::$url);
$I->click(\BlogFeedPage::$postTitleSelector);
$postUrl = $I->grabFromCurrentUrl();
$I->submitCommentForm('Dummy comment');
$I->seeLink('@'.$I->username, \PostPage::$commentSelector);

$newUsername = md5(microtime());
$I->switchUsername($newUsername);
$I->amOnPage($postUrl);
// $I->username is updated automatically during `switchUsername()` call
$I->seeLink('@'.$I->username, \PostPage::$commentSelector);
