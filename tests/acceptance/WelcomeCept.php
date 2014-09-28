<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('view home page');
$I->amOnPage('/');
$I->see('Welcome');
