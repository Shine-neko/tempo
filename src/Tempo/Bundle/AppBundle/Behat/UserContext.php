<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Behat;

use Behat\Behat\Context\Step\When;
use Behat\Mink\Driver\Selenium2Driver;

class UserContext extends BaseContext
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

        $this->getSession()->visit($this->generatePageUrl('user_login'));

        $this->fillField('Username', $username);
        $this->fillField('Password', $password);
        $this->pressButton('login');
        $this->assertPageContainsText('logout');
    }

    /**
     * @Given /^I am on my account password page$/
     */
    public function iAmOnMyAccountPasswordPage()
    {
        $this->getSession()->visit($this->generatePageUrl('user_profile_password'));
    }

    /**
     * @Then /^I should be on login page$/
     */
    public function iShouldBeOnLoginPage()
    {
        $this->assertSession()->addressEquals($this->generateUrl('user_login'));
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
