<?php
/** @type Codeception\Scenario $scenario */
$scenario->groups(array('nonauthenticated', 'blog'));

$I = new WebGuy\MemberSteps($scenario);
$I->wantTo('Play with comments');
$I->amGoingTo('Be very stupid and leave comment several times until blog ' .
    'will consider it correct');
$I->logout();

$I->amOnPage(\BlogFeedPage::$url);
$I->click(\BlogFeedPage::$postTitleSelector);
$I->see('text.commentThisPost');
$currentUrl = $I->grabFromCurrentUrl('~(.*)~');
$I->submitCommentForm();
$I->seeCurrentUrlMatches('~^'.$currentUrl.'~');
\PostPage::of($I)->hasErrors();

$I->submitCommentForm('tralalal');
$I->seeCurrentUrlMatches('~^'.$currentUrl.'~');
\PostPage::of($I)->hasErrors();

$I->submitCommentForm(
    'Hey, look at my local email address!',
    'marabou',
    'marabou@localhost'
);
$I->seeCurrentUrlMatches('~^'.$currentUrl.'~');
\PostPage::of($I)->hasErrors();
// checking form saving
$I->seeInField(\PostPage::$commentTextArea, 'Hey, look at my local email address!');
$I->seeInField(\PostPage::$commentUsernameField, 'marabou');
$I->seeInField(\PostPage::$commentEmailField, 'marabou@localhost');

$I->submitCommentForm('This is first correct comment', 'marabou', '');
$I->seeCurrentUrlMatches('~^'.$currentUrl.'~');
\PostPage::of($I)->hasNoErrors();
$I->see('This is first correct comment');

$I->submitCommentForm(
    'Second correct comment, now using gravatar',
    'marabou',
    'hacker@delight.net'
);
$I->seeCurrentUrlMatches('~^'.$currentUrl.'~');
\PostPage::of($I)->hasNoErrors();
$I->see('Second correct comment, now using gravatar');

$I->autoLogin();
$username = '@'.$I->username;
$I->amOnPage(\BlogFeedPage::$url);
$I->click(\BlogFeedPage::$postTitleSelector);
$I->seeInField(\PostPage::$commentUsernameField, $username);
$currentUrl = $I->grabFromCurrentUrl('~(.*)~');
$I->submitCommentForm();
$I->seeCurrentUrlMatches('~^'.$currentUrl.'~');
\PostPage::of($I)->hasErrors();
$I->submitCommentForm('test comment');
$I->see('comment.submit.success');
$I->see($username, \PostPage::$commentSelector);
$I->see('timeInterval.justNow', \PostPage::$commentSelector);