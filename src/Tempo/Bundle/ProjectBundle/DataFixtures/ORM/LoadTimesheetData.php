<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tempo\Bundle\ProjectBundle\Entity\Timesheet;
use CalendR\Period\Week;


class LoadTimesheetData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userList = array('admin', 'john.doe');

        for ($i = 1; $i <= 5; $i++) {

            $dateList = array();
            $week = new Week((new \DateTime())->setISOdate(date('Y'), date('W')));

            foreach ($week as $day) {
                $dateList[] = $day->getBegin();
            }

            $cra = new Timesheet();
            $cra->setProject($this->getReference('project' . $i));
            $cra->setUser($this->getReference($userList[array_rand($userList, 1)]));
            $cra->setBillable($i % 2);

            $cra->setWorkedTime(str_shuffle('12345678')[0]);

            $cra->setCreatedAt(new \DateTime());
            $cra->setWorkedDate($dateList[array_rand($dateList)]);

            $cra->setDescription('Lorem Ipsum is simply dummy text');

            $manager->persist($cra);
            $manager->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5;
    }

}
