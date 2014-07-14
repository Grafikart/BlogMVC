<?php

use Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$I = new WebGuy\MemberSteps($scenario);
$I->wantTo('Update my password to another one');

$newPassword = md5(microtime());
$I->autoLogin();
$I->updatePassword($newPassword);
$I->logout();
$I->login(Fixtures::get('data:users[0]:login'), $newPassword);
$I->seeCurrentUrlEquals(\AdminPanelPage::$url);
