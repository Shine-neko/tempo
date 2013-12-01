<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;


use Tempo\Bundle\ProjectBundle\Entity\Project;

class LoadProjectData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
        for ($i = 1; $i <= 10; $i++) {

            $userEntity = $this->getReference($userList[array_rand($userList, 1)]);

            $name = str_shuffle('Le Lorem Ipsum');

            $digit = str_shuffle('123456789');
            $code = str_shuffle(substr($name, 0, 3).substr($digit, 0, 3));

            $project = new Project();
            $project->setName($name);
            $project->setCode($code );
            $project->setSlug(str_replace(' ', '-', $name));
            $project->setDescription('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.');
            $project->setOrganization( $this->getReference('organization'.$i));
            $project->setStatus( $this->getReference('projectType'.(rand(1, 3))) );
            $project->setAvancement($digit[0]);
            $project->setCreated(new \DateTime());
            $project->setUpdated(new \DateTime());
            $project->setActive(true);
            $project->setBeginning(new \DateTime());
            $project->setEnding(new \DateTime());
            $project->addTeam($userEntity);

            if($i > 5) {
                $digit = str_shuffle('12345');
                $project->setParent($this->getReference('project'.$digit[0]));
            }

            $manager->persist($project);
            $manager->flush();

            $this->getAclManager()->addObjectPermission($project, MaskBuilder::MASK_OWNER, $userEntity); //set Permission
            $this->addReference('project'.$i, $project);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }

    protected function getAclManager()
    {
        return $this->container->get('problematic.acl_manager');
    }
}
