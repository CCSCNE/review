<?php 
$I = new AcceptanceTester\MemberSteps($scenario);
$I->wantTo('logout');
$I->login('chair1@demo.edu', 'chair1@demo.edu');
$I->amOnPage('/');
$I->click('Log out');
$I->dontSee('chair1@demo.edu');
