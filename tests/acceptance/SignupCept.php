<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('signup');
$I->amOnPage('/');
$I->click('Sign up');
$I->fillField('Email', 'new@user.edu');
$I->fillField('Email Confirmation', 'new@user.edu');
$I->fillField('Password', 'new@user.edu');
$I->fillField('Password Confirmation', 'new@user.edu');
$I->click('form input[type=submit]');
$I->see('new@user.edu');
