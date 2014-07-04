<?php
use Codeception\Util\Fixtures;

$scenario->group('auth', 'front');
$i = new \WebGuy\MemberSteps($scenario);
$i->am('logged-off admin');
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

$i->login(Fixtures::get('data:users[0]:login'), Fixtures::get('data:users[0]:password'));
$i->see('auth.login.greeting');
$i->seeCurrentUrlEquals(\AdminPanelPage::$url);

$i->amOnPage(\LoginPage::$url);
$i->seeCurrentUrlEquals(\AdminPanelPage::$url);
$i->seeAlert('auth.login.alreadyAuthorized');

$i->seeLink('link.logout');
$i->click('link.logout');
$i->seeCurrentUrlEquals(\BlogFeedPage::$url);
//$i->canSee('You have successfully logged out');