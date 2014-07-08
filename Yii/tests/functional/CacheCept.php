<?php 
$I = new TestGuy($scenario);
$I->wantTo('Verify that sidebar is updated correctly');

$sidebarVariations = array(
    'ru' => array(
        'Категории',
        'Последние записи',
    ),
    'en' => array(
        'Categories',
        'Last posts',
    ),
);
foreach ($sidebarVariations as $language => $headings) {
    \Yii::app()->cacheHelper->invalidatePostsCache();
    $I->amOnPage(\BlogFeedPage::$url . '?language=' . $language);
    foreach ($headings as $heading) {
        $I->see($heading, \BlogFeedPage::$sidebarSelector);
    }
}