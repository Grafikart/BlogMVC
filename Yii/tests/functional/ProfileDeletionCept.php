<?php
use Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('front', 'user-management');

$I = new TestGuy($scenario);
$I->wantTo('Delete my account');
$I->expectTo('Lose ability to sign in under my regular account and all my posts');

$login = Fixtures::get('data:users[0]:login');
$password = Fixtures::get('data:users[0]:password');

$I->amOnPage(\AuthorFeedPage::route(1));
// confirming that test landed on required page
$I->see($login, \AuthorFeedPage::$postSelector);

$I->amOnPage(\LoginPage::$url);
$I->submitForm(\LoginPage::$formSelector, array(
    \LoginPage::$loginField => $login,
    \LoginPage::$passwordField => $password
));
$I->amOnPage(\SuicideBoothPage::$url);
$I->click(\SuicideBoothPage::$benderButtonXPath);
$I->seeCurrentUrlEquals('/');

$I->amOnPage(\LoginPage::$url);
$I->submitForm(\LoginPage::$formSelector, array(
    \LoginPage::$loginField => $login,
    \LoginPage::$passwordField => $password
));
$I->see('auth.login.fail');

$I->amOnPage(\AuthorFeedPage::route(1));
$I->see('pageTitle.site.error', \AuthorFeedPage::$pageHeaderSelector);
$I->seeResponseCodeIs(404);

$I->assertNull(\User::findByUsername($login));
$I->assertEmpty(
    \Post::model()->with(
        array(
            'author' => array(
                'condition' => 'author.username = :login',
                'params' => array(':login' => $login,),
            ),
        )
    )->findAll()
);