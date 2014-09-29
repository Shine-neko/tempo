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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Tempo\Bundle\AppBundle\Model\Organization;

class LoadOrganizationData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

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
        $userList = array('admin', 'john.doe');
        $organization = array(
            'Ikimea',
            'Google',
            'Apple',
            'Microsoft',
            'Selenium',
            'Sensiolabs',
            'Twitter',
            'Dell',
            'Facebook',
            'Pinterest',
        );
        $i = 1;
        foreach ($organization as $name) {
            $userEntity = $this->getReference($userList[array_rand($userList, 1)]);

            $organization = new Organization();
            $organization->setName($name);
            $organization->setContact('support@'.$name.'.com');
            $organization->getWebSite('http://'.$name.'.com');
            $organization->addTeam($userEntity);
            $organization->addTeam($this->getReference('olivia.pace'));

            $manager->persist($organization);
            $manager->flush();

            $this->getAclManager()->addObjectPermission($organization, MaskBuilder::MASK_OWNER, $userEntity); //set Permission
            $this->addReference('organization'.$i, $organization);
            $i++;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 20;
    }

    protected function getAclManager()
    {
        return $this->container->get('problematic.acl_manager');
    }
}
