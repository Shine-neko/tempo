<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Tempo\Bundle\ProjectBundle\Entity\ProjectProvider;

class LoadProjectProviderData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<5; $i++) {

            $activityProvider = new ProjectProvider();
            $activityProvider->setCreatedAt(new \DateTime());
            $activityProvider->setName('github');
            $activityProvider->setProject($this->getReference('project'.$i));

            $manager->persist($activityProvider);
            $manager->flush();

            $this->addReference('project_privider_'.$i, $activityProvider);
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 60;
    }
}
