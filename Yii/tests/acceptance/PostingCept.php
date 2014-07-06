<?php

$I = new WebGuy\MemberSteps($scenario);
$I->wantTo('Publish my post');
$I->amGoingTo('Write a post, edit it, delete it, write lots of posts');

$I->autoLogin();

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

$slug = \Codeception\Util\Fixtures::get('data:posts[0]:slug');
$I->editPost($id, null, null, $slug);
\PostFormPage::of($I)->hasNoErrors();
$I->seeInField(\PostFormPage::$slugField, $slug.'-1');

$I->click(\PostFormPage::$categoryMenuToggleButton);
$I->wait(1);
$I->fillField(\PostFormPage::$newCategoryField, 'Phantom menace');
$I->click(\PostFormPage::$submitButton);
$I->click('link.viewPost');
$I->seeLink('Phantom menace', 'phantom-menace');

$I->amOnPage(\PostsDashboardPage::$url);
$I->click('control.delete', '#post-'.$id);
$I->seeCurrentUrlEquals(\PostsDashboardPage::$url);
$I->dontSee('Another title', '#post-'.$id); // flash message containing post title will be shown

$I->amOnPage(\BlogFeedPage::$url);
$I->dontSee('Another title');