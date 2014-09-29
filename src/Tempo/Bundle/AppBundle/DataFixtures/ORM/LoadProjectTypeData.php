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

use Tempo\Bundle\AppBundle\Model\ProjectType;

class LoadProjectTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $types = array(
            'Scrum',
            'Xp',
            'Kanban'
        );

        $i = 1;
        foreach ($types as $type) {
            $projectType = new ProjectType();
            $projectType->setName($type);
            $manager->persist($projectType);
            $manager->flush();
            $this->addReference('projectType'.$i, $projectType);
            $i++;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 30;
    }
}
