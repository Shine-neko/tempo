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

use Faker\Factory as FakerFactory;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;



class DataContext extends RawMinkContext
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
            $this->getMainContext()->fillField('timesheet[period]', date('Y-m-d'));
        }

        foreach ($table->getRowsHash() as $key => $value) {
           $this->getMainContext()->fillField('timesheet['.$key.']', $value);
        }

        $this->getMainContext()->pressButton('Save');
    }
}
