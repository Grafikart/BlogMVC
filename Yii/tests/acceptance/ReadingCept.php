<?php
use Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('blog', 'front', 'auth');

$lastPost = Fixtures::get('data:posts:length') - 1;
$penultimatePagePost = $lastPost - 5;

$I = new \WebGuy\MemberSteps($scenario);
$I->wantTo('read blog');
$I->amGoingTo('read posts from different pages on the main feed and category/author page');
$I->expectTo('see blog posts and encounter 404 on invalid pages');

$I->amOnPage(\BlogFeedPage::$url);
$I->see('heading.lastPosts');
$I->see('heading.categories');
$I->see(Fixtures::get("data:posts[$lastPost]:title"), 'article');
$I->dontSee(Fixtures::get("data:posts[$penultimatePagePost]:title"), 'article');

$I->see('2', 'ul.pagination');
$I->click('2', 'ul.pagination');
$I->seeCurrentUrlEquals(\BlogFeedPage::route(2));
$I->see(Fixtures::get("data:posts[$penultimatePagePost]:title"), 'article');
$I->dontSee(Fixtures::get("data:posts[$lastPost]:title"), 'article');

$I->amOnPage(\BlogFeedPage::route(ceil(Fixtures::get('data:posts:length')/5)+1));
$I->seeHttpErrorPage(404);

// categories

$I->amOnPage(\BlogFeedPage::$url);
$category = \BlogFeedPage::of($I)->getSidebarCategoryTitle(1);
$otherCategory = \BlogFeedPage::of($I)->getSidebarCategoryTitle(2);
$I->click($category, '.sidebar');
$I->seeCurrentUrlMatches(\CategoryFeedPage::$urlRegexp);
$I->seeInTitle($category);
$I->see($category, \CategoryFeedPage::$pageHeaderSelector);
$I->see($category, \CategoryFeedPage::$postCategoryLinkSelector);
$I->dontSee($otherCategory, 'article');

/*
$I->amOnPage(\CategoryFeedPage::route('category-1', 2));
$I->see('heading.httpError [errorCode:404]');
$I->dontSeeElement('article');
*/

// authors

$I->amOnPage(\BlogFeedPage::$url);
$firstPostTitle = $I->grabTextFrom(\BlogFeedPage::$postTitleSelector);
$authorName = $I->grabTextFrom(\BlogFeedPage::$postUserLinkSelector);
$I->click(\AuthorFeedPage::$postUserLinkSelector, 'article');
$I->seeCurrentUrlMatches(\AuthorFeedPage::$urlRegexp);
$I->seeInTitle($authorName);
$I->seeInTitle('pageTitle.user.index');
$I->see($authorName, \AuthorFeedPage::$pageHeaderSelector);
$I->see($firstPostTitle, 'article');

$I->click($firstPostTitle);
$I->seeInTitle($firstPostTitle);
$I->see($firstPostTitle, \PostPage::$postTitleSelector);

$I->amOnPage(\PostPage::route('slug-that-doesnt-exist-in-fixtures'));
$I->seeHttpErrorPage(404);
$I->dontSeeElement('article');