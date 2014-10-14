<?php
use Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('auth', 'front');
$i = new \WebGuy\MemberSteps($scenario);
$i->am('admin');
$i->wantTo('check auth mechanism');
$i->expect('login failure on invalid data and login success on valid data');

$i->logout();
$i->seeCurrentUrlEquals(\BlogFeedPage::$url);
$i->seeAlert('auth.logout.guestAttempt');

$i->seeElement(\FeedPage::$loginLink);
$i->click('link.login');
$i->seeCurrentUrlEquals(\LoginPage::$url);

$i->login(null, null);
$i->seeAlert('auth.login.fail');

$i->login('missing username', 'nonexisting password');
$i->seeAlert('auth.login.fail');

$i->autoLogin();
$i->see('auth.login.greeting');
$i->seeCurrentUrlEquals(\AdminPanelPage::$url);

$i->amOnPage(\LoginPage::$url);
$i->seeCurrentUrlEquals(\AdminPanelPage::$url);
$i->seeAlert('auth.login.alreadyAuthorized');

$i->seeLink('link.logout');
$i->click('link.logout');
$i->seeCurrentUrlEquals(\BlogFeedPage::$url);
//$i->canSee('You have successfully logged out');