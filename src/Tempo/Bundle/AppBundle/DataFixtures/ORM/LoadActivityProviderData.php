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

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;


use Tempo\Bundle\AppBundle\Model\ActivityProvider;

class LoadActivityProviderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $github_provider_content = file_get_contents(__DIR__. '/../Fixtures/github-provider.yml');
        for ($i=1; $i<5; $i++) {

            $activity = (new ActivityProvider())
                ->setProvider($this->getReference('project_privider_'.$i))
                ->setMessage('')
                ->setParameters($github_provider_content)
                ->setCreatedAt(new \DateTime());

            $manager->persist($activity);
            $this->addReference('activity_'.$i, $activity);
        }

        $activity = (new ActivityProvider())
            ->setProvider($this->getReference('project_privider_6'))
            ->setMessage('Build 1 of tempo-project/tempo Passed')
            ->setCreatedAt(new \DateTime())
            ->setParameters(file_get_contents(__DIR__. '/../Fixtures/travis-provider.yml'));
        $manager->persist($activity);
        $manager->flush();

    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 70;
    }
}
