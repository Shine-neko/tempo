<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Tempo\Bundle\AppBundle\Model\Room;

class LoadRoomData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userList = array('admin', 'john.doe');
        $rooms = array(
            'Room1',
            'Room2',
            'Room3',
            'Room4',
            'Room5',
        );

        $i = 1;
        foreach ($rooms as $name) {
            $userEntity = $this->getReference($userList[array_rand($userList, 1)]);

            $room = new Room();
            $room->setName($name);

            $manager->persist($room);
            $room->addUser($userEntity);

            $manager->flush();
            $this->addReference('room'.$i, $room);
            $i++;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 50;
    }
}
