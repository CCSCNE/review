<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('login');
$I->amOnPage('/');
$I->click('Log in');
$I->see('Log in');
$I->fillField(LoginPage::$emailField, 'chair1@demo.edu');
$I->fillField(LoginPage::$passwordField, 'chair1@demo.edu');
$I->click(LoginPage::$submitButton);
$I->see('chair1@demo.edu');
