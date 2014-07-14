<?php

use Codeception\Util\Fixtures;

$I = new WebGuy\MemberSteps($scenario);
$I->am('Web developer');
$I->wantTo('Test cache system by writing post and tweaking service settings');
$I->expectTo('See changes instantly');

$I->autoLogin();

// if any other category is modified but the top one, categories may change
// positions in sidebar, and this behavior would be much harder to test.
define('CATEGORY_NUMBER', 0);

$I->flushCache();
$stats = \ServiceStatusPage::of($I)->grabStats();
$totalPostsNumber = $stats['totalPosts'];
$postsTodayNumber = $stats['postsToday'];
$commentsTodayNumber = $stats['commentsToday'];
$totalCommentsNumber = $stats['totalComments'];

$I->amOnPage(\BlogFeedPage::$url);
$categoryTitle = \BlogFeedPage::of($I)->grabCategoryTitle(CATEGORY_NUMBER);
$categoryPostCount = \BlogFeedPage::of($I)->grabCategoryPostCount(CATEGORY_NUMBER);
$posts = array();


// there were issues with stall cache after series of fast posts, so this
// construct verifies that it doesn't happen again
for ($i = 0; $i < 5; $i++) {
    $title = md5(time()).$i;
    $I->amOnPage(\BlogFeedPage::$url);
    $I->dontSee($title);
    $I->writePost($title, 'superpost is superposted', null, $categoryTitle);
    $elemId = $I->grabAttributeFrom(\PostPage::$postSelector, 'id');
    preg_match('#\d+#', $elemId, $matches);
    $posts[$matches[0]] = $title;
    $I->amOnPage(\BlogFeedPage::$url);
    $I->see($title, \BlogFeedPage::$postTitleSelector);
    $I->see($title, \BlogFeedPage::$sidebarPostListSelector);
    $totalPostsNumber++;
    $postsTodayNumber++;
    $categoryPostCount++;
}
// verify stats
$I->amOnPage(\ServiceStatusPage::$url);
$I->see($totalPostsNumber, \ServiceStatusPage::$totalPostsSelector);
$I->see($postsTodayNumber, \ServiceStatusPage::$postsTodaySelector);
$I->amOnPage(\BlogFeedPage::$url);
$I->see(
    $categoryPostCount,
    \BlogFeedPage::getCategoryPostCountSelector(CATEGORY_NUMBER)
);

foreach ($posts as $id => $title) {
    $I->amOnPage(\PostsDashboardPage::$url);
    \PostsDashboardPage::of($I)->clickDeletePostButton($id);
    $I->amOnPage(\BlogFeedPage::$url);
    $I->dontSee($title, \BlogFeedPage::$postTitleSelector);
    $I->dontSee($title, \BlogFeedPage::$sidebarPostLinkTemplate);
    $totalPostsNumber--;
    $postsTodayNumber--;
    $categoryPostCount--;
}
$I->amOnPage(\ServiceStatusPage::$url);
$I->see($totalPostsNumber, \ServiceStatusPage::$totalPostsSelector);
$I->see($postsTodayNumber, \ServiceStatusPage::$postsTodaySelector);
$I->amOnPage(\BlogFeedPage::$url);
$I->see(
    $categoryPostCount,
    \BlogFeedPage::getCategoryPostCountSelector(CATEGORY_NUMBER)
);

$I->amOnPage(\BlogFeedPage::$url);
$I->click(\BlogFeedPage::$postTitleSelector);
$postUrl = $I->grabFromCurrentUrl();

for ($i = 0; $i < 5; $i++) {
    $I->submitCommentForm('test-comment');
    $commentsTodayNumber++;
    $totalCommentsNumber++;
}

$I->amOnPage(\ServiceStatusPage::$url);
$I->see($commentsTodayNumber, \ServiceStatusPage::$commentsTodaySelector);
$I->see($totalCommentsNumber, \ServiceStatusPage::$totalCommentsSelector);

$I->amOnPage($postUrl);
for ($i = 0; $i < 5; $i++) {
    $I->click(\PostPage::$deleteCommentLink);
    $totalCommentsNumber--;
    $commentsTodayNumber--;
}

$I->amOnPage(\ServiceStatusPage::$url);
$I->see($commentsTodayNumber, \ServiceStatusPage::$commentsTodaySelector);
$I->see($totalCommentsNumber, \ServiceStatusPage::$totalCommentsSelector);
