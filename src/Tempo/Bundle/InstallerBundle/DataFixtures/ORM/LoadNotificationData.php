<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\InstallerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Tempo\Bundle\AppBundle\Model\Notification;

class LoadNotificationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userList = array('admin', 'john.doe', 'olivia.pace');

        for ($i = 0; $i < 50; $i++) {
            $userEntity = $this->getReference($userList[array_rand($userList, 1)]);

            $notification = new Notification();
            $notification->setMessage(str_shuffle('Lorem ipsum dolor sit amet, consectetur adipisci elit'));
            $notification->setUser($userEntity);
            $notification->setLink('#');

            $manager->persist($notification);
            $manager->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 90;
    }
}
