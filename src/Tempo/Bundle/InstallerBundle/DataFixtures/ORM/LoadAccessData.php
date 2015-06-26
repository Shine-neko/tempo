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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Tempo\Bundle\AppBundle\Model\Access;

class LoadAccessData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $access = (new Access())
            ->setInviteEmail('dexter.schwartz@tempo-project.org')
            ->setInviteToken(sha1(uniqid(rand(), true)))
            ->setLabel(Access::TYPE_COLLABORATOR)
            ->setSource($this->getReference('project1'));

        $this->container->get('tempo.domain_manager')->create($access);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 80;
    }
}