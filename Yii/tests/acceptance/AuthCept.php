<?php
$i = new WebGuy($scenario);
$i->am('logged-off admin');
$i->wantTo('check auth mechanism');
$i->expect('login failure on invalid data and login success on valid data');

$i->amOnPage('/logout');
$i->seeCurrentUrlEquals('/');
$i->see('You haven\'t been logged in. Why are you trying to logout?');

$i->see('Login');
$i->click('Login');
$i->see('Please sign in');
$i->click('Sign in');
$i->see('Incorrect username or password');

$i->fillField('User[username]', 'a');
$i->fillField('User[password]', 'b');
$i->click('Sign in');
$i->see('Incorrect username or password');

$i->fillField('User[username]', 'admin');
$i->fillField('User[password]', 'admin');
$i->click('Sign in');
$i->see('You have successfully logged in');
$i->seeCurrentUrlEquals('/admin');

$i->amOnPage('/login');
$i->seeCurrentUrlEquals('/admin');
$i->see('You are already authorized, no need to retry.');

$i->see('Logout');
$i->click('Logout');
$i->seeCurrentUrlEquals('/');
//$i->see('You have successfully logged out');