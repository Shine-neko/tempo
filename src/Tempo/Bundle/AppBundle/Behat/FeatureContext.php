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

use Symfony\Component\HttpFoundation\Request;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\ResponseTextException;


/**
 * Features context.
 */
class FeatureContext extends BaseContext
{

    public function __construct()
    {
        Request::enableHttpMethodParameterOverride();
    }

    /**
     * Get service by id.
     *
     * @param string $id
     *
     * @return object
     */
    private function getService($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * Returns Container instance.
     *
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * Generate url.
     *
     * @param string  $route
     * @param array   $parameters
     * @param Boolean $absolute
     *
     * @return string
     */
    public function generateUrl($route, array $parameters = array(), $absolute = false)
    {
        return $this->getService('router')->generate($route, $parameters, $absolute);
    }

    /**
     * @Given /^I am on route "([^"]*)"$/
     */
    public function iAmOnRoute($route)
    {
        $url = $this->kernel->getContainer()->get('router')->generate($route, array(), false);
        $this->getSession()->visit($this->locatePath($url));
    }

    /**
     * @When /^I am on route "([^"]*)" with query "([^"]*)"$/
     */
    public function iAmOnRouteWithQuery($route, $parameters)
    {
        parse_str($parameters, $parameters);

        $url = $this->kernel->getContainer()->get('router')->generate($route, $parameters, false);

        $this->getSession()->visit($this->locatePath($url));
    }

    /**
     * @param string $text
     *
     * @Then /^I should see (?:a )?flash message "([^"]*)"$/
     */
    public function iShouldSeeFlashMessage($text)
    {
        if (!$this->assertSession()->elementExists('css', '.flash-message')) {
            throw new \Exception('No flash messages found');
        }

        if ($this->getSession()->getDriver() instanceof Selenium2Driver) {
            $message = $this->getSession()->getPage()->find('css', '.flash-message')->getText();
            $message = ltrim($message, '× ');

            if ($message !== $text) {
                throw new ResponseTextException($text, $this->getSession());
            }

            return;
        }

        $this->assertSession()->pageTextContains($text);

    }

    /**
     * @Given /^I wait (\d+) (seconds|second)$/
     */
    public function iWait($time)
    {
        $this->getSession()->wait($time * 1000);
    }

    /**
     * @When /^(?:|I )wait for "(?P<element>[^"]*)" to be visible$/
     */
    public function waitForVisible($element, $time = 5000)
    {
        if (!$this->getSession()->getDriver() instanceof Selenium2Driver) {
            return;
        }

        $this->getSession()->wait($time, "jQuery('" . $element . "').is(':visible')");
    }

    /**
     * Wait
     *
     * @param int $time
     * @param null $condition
     * @throws \Exception If timeout is reached
     */
    public function wait($time = 10000, $condition = null)
    {
        if (!$this->getSession()->getDriver() instanceof Selenium2Driver) {
            return;
        }

        $start = microtime(true);
        $end = $start + $time / 1000.0;

        $condition = $condition !== null ? $condition : <<<JS
        document.readyState == 'complete'                  // Page is ready
            && typeof $ != 'undefined'                     // jQuery is loaded
            && !$.active                                   // No ajax request is active
            && $('#page').css('display') == 'block'        // Page is displayed (no progress bar)
            && $('.loading-mask').css('display') == 'none' // Page is not loading (no black mask loading page)
            && $('.jstree-loading').length == 0;           // Jstree has finished loading
JS;

        // Make sure the AJAX calls are fired up before checking the condition
        $this->getSession()->wait(100, false);

        $this->getSession()->wait($time, $condition);

        // Check if we reached the timeout unless the condition is false to explicitly wait the specified time
        if ($condition !== false && microtime(true) > $end) {
            throw new \Exception(sprintf('Timeout of %d reached when checking on %s', $time, $condition));
        }
    }
    /**
     * Click on the element with the provided xpath query
     *
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        ); // runs the actual query and returns the element

        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }

        // ok, let's click on it
        $element->click();

    }

    /**
     * Click on the element with the provided CSS Selector
     *
     * @When /^I click on the element with css selector "([^"]*)"$/
     */
    public function iClickOnTheElementWithCSSSelector($cssSelector)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('css', $cssSelector) // just changed xpath to css
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $cssSelector));
        }

        $element->click();

    }

    /**
     * @Then /^I should see the modal "([^"]*)"$/
     */
    public function iShouldSeeTheModal($title)
    {
        $this->assertSession()->elementExists('css', '.modal-title');

        //$this->wait();
        //$this->assertSession()->pageTextContains($title);

        /**

        $this->assertTrue($this->getSession()->getPage()->find('css', '#modal-from-dom')->isVisible());
         */
    }

}
