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

use Faker\Factory as FakerFactory;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_ExpectationFailedException as AssertException;

class DataContext extends BaseContext
{
    /**
     * Faker.
     *
     */
    private $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    /**
     * @Given /^I created cra:$/
     */
    public function iCreatedCraNameDescription(TableNode $table)
    {
        if (!isset($table->getRowsHash()['period'])) {
            $this->fillField('timesheet[workedDate]', date('Y-m-d'));
        }

        foreach ($table->getRowsHash() as $key => $value) {
           $this->fillField('timesheet['.$key.']', $value);
        }

        $this->pressButton('Save');
    }

    /**
     * @Given /^the following timesheet exist:$/
     * @throws ExpectationException
     */
    public function assertPageContainsTextsInOrder(TableNode $table)
    {
        $texts = array();
        foreach ($table->getRows() as $row) {
            $texts[] = $row[0];
        }
        $pattern = "/".implode(".*", $texts)."/s";

        $actual = $this->getSession()->getPage()->getText();

        try {
            \PHPUnit_Framework_Assert::assertRegExp($pattern, $actual);
        } catch (\AssertException $e) {
            $message = sprintf('The texts "%s" was not found in order anywhere on the current page', implode('", "', $texts));
            throw new ExpectationException($message, $this->getSession(), $e);
        }
    }
}
