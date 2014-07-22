<?php
/** @type \Codeception\Scenario $scenario */
$scenario->groups('admin', 'settings');

$I = new \WebGuy\MemberSteps($scenario);
$I->wantTo('Play with settings');
$I->amGoingTo('Tweak themes, languages and names');

$I->autoLogin();
$I->amOnPage(\OptionsPage::$url);
$I->setCookie('useDefaultLanguage', 'true');
\OptionsPage::of($I)->updateOptions(
    'Horse Tickler\'s Dagger Fan Club',
    'ru',
    'ambinight'
);
$I->seeCurrentUrlEquals(\OptionsPage::$url);
$I->seeInTitle('Horse Tickler\'s Dagger Fan Club');
$I->seeOptionIsSelected(\OptionsPage::$siteLanguageList, 'ru');
$I->seeOptionIsSelected(\OptionsPage::$themeList, 'ambinight');
$I->see('Настройки', \OptionsPage::$pageHeaderSelector);
$I->amOnPage(\BlogFeedPage::$url);
$I->see('Категории', \BlogFeedPage::$sidebarSelector);