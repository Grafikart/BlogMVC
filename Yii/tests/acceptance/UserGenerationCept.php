<?php

/** @type \Codeception\Scenario $scenario */
$scenario->groups('front', 'settings');

$I = new WebGuy\MemberSteps($scenario);
$I->am('admin');
$I->wantTo('add my friend as a new user');

$random = md5(microtime());

$I->autoLogin();
$I->amOnPage(\UsersDashboardPage::$url);
$I->click(\UsersDashboardPage::$createNewButtonSelector);


$I->seeCurrentUrlEquals(\CreateNewUserPage::$url);
$I->fillField(\CreateNewUserPage::$usernameFieldSelector, $random);
$I->click(\CreateNewUserPage::$submitButtonSelector);


$I->seeCurrentUrlEquals(\CreateNewUserPage::$url);
$I->seeAlert('user.creation.fail');
// testing validation and data binding
$I->seeElement(\CreateNewUserPage::$passwordFieldSelector.'.error');
$I->seeElement(\CreateNewUserPage::$repeatPasswordFieldSelector.'.error');
$I->dontSeeElement(\CreateNewUserPage::$usernameFieldSelector.'.error');
$I->seeInField(\CreateNewUserPage::$usernameFieldSelector, $random);

$I->fillField(\CreateNewUserPage::$passwordFieldSelector, $random);
$I->click(\CreateNewUserPage::$submitButtonSelector);


$I->seeCurrentUrlEquals(\CreateNewUserPage::$url);
$I->seeAlert('user.creation.fail');
$I->seeInField(\CreateNewUserPage::$usernameFieldSelector, $random);
$I->seeInField(\CreateNewUserPage::$passwordFieldSelector, $random);
$I->seeElement(\CreateNewUserPage::$repeatPasswordFieldSelector.'.error');
$I->dontSeeElement(\CreateNewUserPage::$passwordFieldSelector.'.error');
$I->dontSeeElement(\CreateNewUserPage::$usernameFieldSelector.'.error');

$I->fillField(\CreateNewUserPage::$passwordFieldSelector, '0');
$I->fillField(\CreateNewUserPage::$repeatPasswordFieldSelector, '0');
$I->click(\CreateNewUserPage::$submitButtonSelector);


$I->seeCurrentUrlEquals(\CreateNewUserPage::$url);
$I->seeAlert('user.creation.fail');

$I->fillField(\CreateNewUserPage::$usernameFieldSelector, '0');
$I->fillField(\CreateNewUserPage::$passwordFieldSelector, $random);
$I->fillField(\CreateNewUserPage::$repeatPasswordFieldSelector, $random);
$I->click(\CreateNewUserPage::$submitButtonSelector);


$I->seeCurrentUrlEquals(\CreateNewUserPage::$url);
$I->seeAlert('user.creation.fail');

$I->fillField(\CreateNewUserPage::$usernameFieldSelector, $random);
$I->click(\CreateNewUserPage::$submitButtonSelector);


$I->seeCurrentUrlMatches('~^'.\UsersDashboardPage::$url.'~');
$I->see($random, \UsersDashboardPage::$createdUserRowSelector);