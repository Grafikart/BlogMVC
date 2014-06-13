<?php
/** @type Codeception\Scenario $scenario */
$scenario->groups(array('nonauthenticated', 'blog'));

$I = new WebGuy\VisitorSteps($scenario);
$I->wantTo('Leave an anonimous comment');
$I->amGoingTo('Be very stupid and leave comment several times until blog will consider it correct');

$I->amOnPage(\BlogFeedPage::$url);
$I->click('article h2 a');
$I->see('Comment this post');
$currentUrl = $I->grabFromCurrentUrl('~(.*)~');
$urlWithHash = $currentUrl.'#comment-form';
$I->submitCommentForm();
$I->seeCurrentUrlEquals($urlWithHash);
\PostPage::of($I)->hasErrors();
$I->submitCommentForm('tralalal');
$I->seeCurrentUrlEquals($urlWithHash);