<?php
use \Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('internals', 'content', 'update');

$I = new TestGuy($scenario);
$I->am('Dr. Jan Itor');
$I->wantTo('Update my nickname and see fancy cascade of nickname update in '.
    'previous comments');

$login = Fixtures::get('data:users[0]:login');
$password = Fixtures::get('data:users[0]:password');

$I->amOnPage(\LoginPage::$url);
$I->submitForm(\LoginPage::$formSelector, array(
    \LoginPage::$loginField => $login,
    \LoginPage::$passwordField => $password
));

$I->amOnPage(\BlogFeedPage::$url);
$I->click(\BlogFeedPage::$postTitleSelector);
$url = $I->grabFromCurrentUrl();

$I->submitForm(\PostPage::$commentForm, array(
    \PostPage::$commentTextArea => 'sample comment',
));

$newUsername = md5(microtime());
$I->amOnPage(\ProfilePage::$url);
$I->submitForm(\ProfilePage::$usernameUpdateFormSelector, array(
    \ProfilePage::$usernameField => $newUsername,
));
$I->see('profile.usernameUpdate.success');

$I->amOnPage($url);
$I->seeLink('@'.$newUsername);


\Yii::app()->fixtureManager->prepare();
