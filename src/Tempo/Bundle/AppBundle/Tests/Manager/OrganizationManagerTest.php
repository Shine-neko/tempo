<?php

namespace Tempo\Bundle\AppBundle\Tests\Manager;


use Tempo\Bundle\AppBundle\Manager\OrganizationManager;

class OrganizationManagerTest extends \PHPUnit_Framework_TestCase
{
    const ORGANIZATION_CLASS = 'Tempo\Bundle\AppBundle\Entity\Project';

    public function setUp()
    {
        $this->em = $this->getMock('\Doctrine\ORM\EntityManager', array(
                'getRepository',
                'getClassMetadata',
                'persist',
                'flush',
                'remove'
            ), array(), '', false
        );

        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');

        $this->em->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::ORGANIZATION_CLASS))
            ->will($this->returnValue($this->repository));


        $this->em->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::ORGANIZATION_CLASS))
            ->will($this->returnValue($class));


        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::ORGANIZATION_CLASS));

        $this->organizationManager = $this->createOrganizationManager($this->em, static::ORGANIZATION_CLASS);

    }

    protected function createOrganizationManager($objectManager, $userClass)
    {
        return new OrganizationManager(
            $objectManager, $userClass
        );
    }

    protected function getOrganization()
    {
        $projectClass = static::ORGANIZATION_CLASS;

        return new $projectClass();
    }

    public function testDeleteOrga()
    {
        $project = $this->getOrganization();
        $this->em
            ->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($project));
        $this->em->expects($this->once())->method('flush');

        $this->organizationManager->remove($project);
    }
}
