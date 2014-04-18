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

class LoadTimesheetData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userList = array('admin', 'john.doe');
        $day = date("w");

        for ($i = 1; $i <= 5; $i++) {

            $dateList = array();

            for ($k = 1; $k < 8; $k++) {
                $dateList[] = date("d", mktime(0, 0, 0, date("n"), date("d") - $day + $k, date("y")));
            }

            $cra = new Timesheet();
            $cra->setProject($this->getReference('project' . $i));
            $cra->setUser($this->getReference($userList[array_rand($userList, 1)]));
            $cra->setBillable($i % 2);

            $cra->setWorkedTime(str_shuffle('12345678')[0]);

            $date = date('Y') . '-' . date('m') . '-' . $dateList[array_rand($dateList, 1)];

            $cra->setCreatedAt(new \DateTime());
            $cra->setWorkedDate(new \DateTime($date));

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
