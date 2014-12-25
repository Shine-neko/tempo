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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Tempo\Bundle\AppBundle\Model\Project;

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
        $i = 1;
        $userList = array('admin', 'john.doe');
        $projectList = array(
            'Bebop','Galasphere','Messie','Sérénité','Luciole ', 'Prometheus',
            'Nimbus','Spartacus','Gothlauth','Dentless'
        );

        foreach ($projectList as $name) {
            $userEntity = $this->getReference($userList[array_rand($userList, 1)]);

            $digit = str_shuffle('123456789');
            $code = str_shuffle(substr($name, 0, 3).substr($digit, 0, 3));

            $project = new Project();
            $project->setName($name);
            $project->setCode($code );
            $project->setSlug(str_replace(' ', '-', $name));
            $project->setDescription('Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.');
            $project->setOrganization( $this->getReference('organization'.$i));
            $project->setStatus( $this->getReference('projectType'.(rand(1, 3))) );
            $project->setAdvancement($digit[0]);
            $project->setCreatedAt(new \DateTime());
            $project->setUpdatedAt(new \DateTime());
            $project->setActive(true);
            $project->setBeginning(new \DateTime());
            $project->setEnding(new \DateTime());

            if ($i > 5) {
                $digit = str_shuffle('12345');
                $project->setParent($this->getReference('project'.$digit[0]));
            }

            $manager->persist($project);
            $manager->flush();

            $project->addUser($userEntity, 1);
            $project->addUser($this->getReference('olivia.pace'), 3);

            $manager->persist($project);
            $manager->flush();

            $this->getAclManager()->addObjectPermission($project, MaskBuilder::MASK_OWNER, $userEntity); //set Permission
            $this->getAclManager()->addObjectPermission($project, MaskBuilder::MASK_OWNER, $this->getReference('olivia.pace')); //set Permission
            $this->addReference('project'.$i, $project);
            $i++;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 40;
    }

    protected function getAclManager()
    {
        return $this->container->get('problematic.acl_manager');
    }
}
