<?php

/** @todo New category */

$I = new WebGuy\MemberSteps($scenario);
$I->wantTo('Publish my post');
$I->amGoingTo('Write a post, edit it, delete it, write lots of posts');

$I->adminLogin();

$I->writePost('', '');
$I->seeCurrentUrlEquals(\PostFormPage::$newPostUrl);
\PostFormPage::of($I)->hasErrors();

$I->writePost('What a title', '');
$I->seeCurrentUrlEquals(\PostFormPage::$newPostUrl);
\PostFormPage::of($I)->hasErrors();

$I->writePost('What a title', 'whatapost');
$I->seeCurrentUrlEquals(\PostFormPage::$newPostUrl);
\PostFormPage::of($I)->hasErrors();

$I->writePost('', 'whatapostapost');
$I->seeCurrentUrlEquals(\PostFormPage::$newPostUrl);
\PostFormPage::of($I)->hasErrors();

$I->writePost('What a title', '*whatapostapost*');
$I->dontSeeInCurrentUrl(\PostFormPage::$newPostUrl);
\PostFormPage::of($I)->hasNoErrors();
$I->seeCurrentUrlEquals(\PostPage::route('what-a-title'));
$I->see('whatapostapost', 'article em');
$I->seeInTitle('What a title');
$I->seeLink('link.edit');
$I->click('link.edit');
$id = $I->grabFromCurrentUrl('~(\\d+)~');

$I->amOnPage(\BlogFeedPage::$url);
$I->see('What a title', '.sidebar');

$I->editPost($id, '');
\PostFormPage::of($I)->hasErrors();

$I->editPost($id, 'Another title', '');
\PostFormPage::of($I)->hasErrors();

$I->editPost($id, 'Another title');
\PostFormPage::of($I)->hasNoErrors();

$I->amOnPage(\BlogFeedPage::$url);
$I->see('Another title', '.sidebar');

$I->editPost($id, 'Another title', null, '');
\PostFormPage::of($I)->hasNoErrors();
$I->seeInField(\PostFormPage::$slugField, 'another-title');

$I->editPost($id, null, null, 'the-route-of-all-evil');
\PostFormPage::of($I)->hasNoErrors();
$I->seeInField(\PostFormPage::$slugField, 'the-route-of-all-evil-1');

$I->amOnPage(\PostsDashboardPage::$url);
$I->click('control.delete', '#post-'.$id);
$I->seeCurrentUrlEquals(\PostsDashboardPage::$url);
$I->dontSee('Another title', '#post-'.$id); // flash message containing post title will be shown

$I->amOnPage(\BlogFeedPage::$url);
$I->dontSee('Another title');

for ($i = 0; $i < 25; $i++) {
    $I->writePost('test-post', 'a, b, c, and their fellow d', 'Category #1');
}
$I->amOnPage(\PostsDashboardPage::$url);
$I->see('2', 'ul.pagination');

$I->amOnPage(\BlogFeedPage::route(7));
$I->see('7', 'ul.pagination .active');