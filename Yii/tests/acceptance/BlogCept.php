<?php
$scenario->groups('blog', 'front', 'auth');
$I = new \WebGuy\MemberSteps($scenario);
$I->wantTo('read blog');
$I->amGoingTo('read posts from different pages on the main feed and category/author page');
$I->expectTo('see blog posts and encounter 404 on invalid pages');

$I->amOnPage(\BlogFeedPage::$url);
$I->see('Last posts');
$I->see('Categories');
$I->see('The Route Of All Evil', 'article');
$I->dontSee('Rebirth', 'article');

$I->see('2', 'ul.pagination');
$I->click('2', 'ul.pagination');
$I->seeCurrentUrlEquals(\BlogFeedPage::route(2));
$I->see('Rebirth', 'article');
$I->dontSee('Future shock', 'article');

$I->amOnPage(\BlogFeedPage::route(3));
$I->see('heading.httpError');

// categories

$I->amOnPage(\BlogFeedPage::$url);
$I->click('Category #1');
$I->seeCurrentUrlEquals(\CategoryFeedPage::route('category-1'));
//$I->canSeeInTitle('Category #1');
$I->see('Space Pilot 3000', 'article');
$I->see('Parasites Lost', 'article');
$I->dontSee('The Route Of All Evil', 'article');

$I->amOnPage(\CategoryFeedPage::route('category-1', 2));
$I->see('Page not found');
$I->dontSeeElement('article');

// authors

$I->amOnPage(\BlogFeedPage::$url);
$I->see('admin', 'article');
$I->click('admin', 'article');
$I->seeCurrentUrlEquals(\AuthorFeedPage::route(1));
$I->see('The Route Of All Evil', 'article');
$I->dontSee('Rebirth', 'article');
$I->see('2', 'ul.pagination');
$I->click('2', 'ul.pagination');
$I->seeCurrentUrlEquals(\AuthorFeedPage::route(1, 2));
$I->see('Rebirth', 'article');
$I->dontSee('Future shock', 'article');
$I->amOnPage(\AuthorFeedPage::route(1, 3));
$I->see('Page not found');
$I->dontSeeElement('article');

// commenting

$I->amOnPage(\BlogFeedPage::$url);
$I->click('The Route Of All Evil', 'article');
$I->seeCurrentUrlEquals(\PostPage::route('the-route-of-all-evil'));
$I->see('Category #3', 'article');
$I->see('admin', 'article');
$I->submitCommentForm(
    'Unauthenticated comment',
    'noauth',
    null
);
$urlRegex = '~^'.\PostPage::route('the-route-of-all-evil').'~';
$I->seeCurrentUrlMatches($urlRegex);
$I->see('Unauthenticated comment', \PostPage::$commentSelector);
$I->dontSee('delete', \PostPage::$deleteCommentLink);

$I->adminLogin();
$I->amOnPage(\BlogFeedPage::$url);
$I->click('The Route Of All Evil', 'article');
$I->seeCurrentUrlEquals(\PostPage::route('the-route-of-all-evil'));
$I->commentAuthenticated('Well, that\'s an authenticated comment');
$I->seeCurrentUrlMatches($urlRegex);
$I->see('@admin', \PostPage::$commentSelector);
$I->see('Well, that\'s an authenticated comment', \PostPage::$commentSelector);
$I->see('delete', \PostPage::$deleteCommentLink);
$I->click('[role="delete-comment"]');
$I->seeCurrentUrlEquals(\PostPage::route('the-route-of-all-evil'));
$I->dontSee('Well, that\'s an authenticated comment', \PostPage::$commentSelector);