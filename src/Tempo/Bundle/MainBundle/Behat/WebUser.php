<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Behat;

use Behat\Behat\Context\Step\When;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;

class WebUser extends RawMinkContext
{
    /**
     * @Given /^I logout$/
     */
    public function iLogout()
    {
        return array(
            new When('I am on "/logout"'),
        );
    }

    /**
     * @Given /^I am connected as "((?:[^"]|"")*)"(?: with password "((?:[^"]|"")*)")?$/
     */
    public function iAmConnectedAs($username, $password = '')
    {
        $password = $password ?: $username;

        $this->getSession()->visit($this->getMainContext()->generateUrl('fos_user_security_login'));

        $this->getMainContext()->fillField('Username', $username);
        $this->getMainContext()->fillField('Password', $password);
        $this->getMainContext()->pressButton('login');
        $this->getMainContext()->assertPageContainsText('logout');
    }

    /**
     * @Then /^I should still be on my account password page$/
     */
    public function iShouldStillBeOnMyAccountPasswordPage()
    {
        $this->assertSession()->addressEquals($this->getMainContext()->generateUrl('user_profile_password'));
    }

    /**
     * @Given /^I am on my account password page$/
     */
    public function iAmOnMyAccountPasswordPage()
    {
        $this->getSession()->visit($this->getMainContext()->generatePageUrl('user_profile_password'));
    }

    /**
     * @Then /^I should be on login page$/
     */
    public function iShouldBeOnLoginPage()
    {
        $this->assertSession()->addressEquals($this->getMainContext()->generateUrl('fos_user_security_login'));
        $this->assertStatusCodeEquals(200);
    }

    /***
     * Assert that given code equals the current one.
     *
     * @param integer $code
     */
    private function assertStatusCodeEquals($code)
    {
        if (!$this->getSession()->getDriver() instanceof Selenium2Driver) {
            $this->assertSession()->statusCodeEquals($code);
        }
    }
}
