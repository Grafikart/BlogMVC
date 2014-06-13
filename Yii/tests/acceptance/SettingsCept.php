<?php
$I = new \WebGuy\MemberSteps($scenario);
$I->wantTo('Play with settings');
$I->amGoingTo('Ensure cache is handled right and change application options');

$I->login('admin', 'admin');
$I->amOnPage(\OptionsPage::$url);
$I->setCurrentPage('\OptionsPage');
$defaultTitle = $I->grabValueFrom(\OptionsPage::$appTitleField);
$defaultLanguage = $I->grabValueFrom(\OptionsPage::$siteLanguageList);
$defaultTheme = $I->grabValueFrom(\OptionsPage::$themeList);

$I->currentPage->updateOptions(
    'Horse Tickler\'s Dagger Fan Club',
    'ru',
    'simple'
);
$I->seeCurrentUrlEquals(\OptionsPage::$url);
$I->seeInTitle('Horse Tickler\'s Dagger Fan Club');
$I->seeOptionIsSelected(\OptionsPage::$siteLanguageList, 'ru');
$I->seeOptionIsSelected(\OptionsPage::$themeList, 'simple');

$I->currentPage->updateOptions(
    $defaultTitle,
    $defaultLanguage,
    $defaultTheme
);

$I->adminLogin();
$I->amOnPage(\BlogFeedPage::$url);
$categories = \FeedPage::of($I)->grabCategories();
$stats = \ServiceStatusPage::of($I)->grabStats();

$I->writePost('dummy post', 'dummy post', 'dummy-post', $categories[0]['name']);

$I->amOnPage(\ServiceStatusPage::$url);
$I->see($stats['postsToday'] + 1, \ServiceStatusPage::$postsTodayContainer);
$I->see($stats['totalPosts'] + 1, \ServiceStatusPage::$totalPostsContainer);

$I->amOnPage(\BlogFeedPage::$url);
$I->see($categories[0]['amount'] + 1, '.categories .item-1');

