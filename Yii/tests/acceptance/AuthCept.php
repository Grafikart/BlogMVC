<?php
$scenario->group('auth', 'front');
$i = new \WebGuy\MemberSteps($scenario);
$i->am('logged-off admin');
$i->wantTo('check auth mechanism');
$i->expect('login failure on invalid data and login success on valid data');

$i->logout();
$i->seeCurrentUrlEquals(\FeedPage::$homeLink);
$i->see('You haven\'t been logged in. Why are you trying to logout?');

\FeedPage::of($i)->openResponsiveMenu();
$i->seeElement(\FeedPage::$loginLink);
$i->click('Login');
$i->seeCurrentUrlEquals(\LoginPage::$url);

$i->login(null, null);
$i->see('Incorrect username or password');

$i->login('missing username', 'nonexisting password');
$i->see('Incorrect username or password');

$i->login('admin', 'admin');
$i->see('You have successfully logged in');
$i->seeCurrentUrlEquals(\AdminPanelPage::$url);

$i->amOnPage(\LoginPage::$url);
$i->seeCurrentUrlEquals(\AdminPanelPage::$url);
$i->see('You are already authorized, no need to retry.');

\FeedPage::of($i)->openResponsiveMenu();
$i->see('Logout');
$i->click('Logout');
$i->seeCurrentUrlEquals(\FeedPage::$homeLink);
//$i->canSee('You have successfully logged out');