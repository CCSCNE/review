<?php
namespace AcceptanceTester;

class MemberSteps extends \AcceptanceTester
{
    public function login($email, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->fillField(\LoginPage::$emailField, $email);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->click(\LoginPage::$submitButton);
    }

    public function logout()
    {
        $I = $this;
    }
}
