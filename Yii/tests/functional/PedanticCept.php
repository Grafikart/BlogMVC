<?php
// Most idiotic cept ever
// Checks that every page has correct translation and correct access control
// That means that it has to be updated nearly on every sneeze

use \Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('front');

\Yii::app()->fixtureManager->prepare();

$I = new TestGuy($scenario);
$I->am('A superpedantic person');
$I->wantTo('Find translation error or improper "back to" link');
$I->expectTo('Fail in my quest');

$languages = array('en', 'ru');
$basePath = \Yii::getPathOfAlias('application.tests._data.pageData');
$privatePages = require $basePath.'/pages-auth.php';
$publicPages = require $basePath.'/pages-public.php';

$I->amOnPage(\LoginPage::$url);
$I->submitForm(\LoginPage::$formSelector, array(
    \LoginPage::$loginField => Fixtures::get('data:users[0]:login'),
    \LoginPage::$passwordField => Fixtures::get('data:users[0]:password'),
));

foreach ($languages as $language) {
    \Yii::app()->language = $language;
    $I->setCookie('language', $language);
    $path = $basePath.'/language-'.$language.'.php';
    $data = require $path;
    foreach ($data as $url => $details) {
        $I->amOnPage($url);
        if (isset($details['title'])) {
            $I->seeInTitle($details['title']);
        }
        if (isset($details['nav'])) {
            foreach ($details['nav'] as $navItem) {
                $I->see($navItem, \GeneralPage::$pageHeaderNavigationSelector);
            }
        }
        if (isset($details['backTo'])) {
            $backTo = \Yii::t(
                'templates',
                'link.backTo',
                array('{pageTitle}' => $details['backTo'],)
            );
            $I->see($details['backTo'], \GeneralPage::$backLink);
        }
    }
}

$I->amOnPage(\UsersDashboardPage::$url.'?language=ru');
$I->see('Создать пользователя');

$I->click(\GeneralPage::$logoutLinkXPath);
$I->resetCookie('language');

$prepareData = function ($data, $redirects = false) {
    if (!is_array($data)) {
        $data = array($data);
    }
    $defaults = array(
        'opts' => array(),
        'method' => 'get',
        'expectedCode' => 200,
        'redirects' => $redirects,
    );
    foreach ($defaults as $key => $value) {
        if (!isset($data[$key])) {
            $data[$key] = $value;
        }
    }
    $data['url'] = \Yii::app()->createUrl($data[0], $data['opts']);
    return $data;
};
foreach ($publicPages as $def) {
    $data = $prepareData($def);
    $I->amOnPage($data['url']);
    if (!$data['redirects']) {
        $I->canSeeCurrentUrlEquals($data['url']);
    }
    $I->canSeeResponseCodeIs($data['expectedCode']);
}
foreach ($privatePages as $def) {
    $data = $prepareData($def, true);
    $I->amOnPage($data['url']);
    if ($data['redirects']) {
        $I->canSeeCurrentUrlEquals(\LoginPage::$url);
    } else {
        $I->canSeeResponseCodeIs(403);
    }
}