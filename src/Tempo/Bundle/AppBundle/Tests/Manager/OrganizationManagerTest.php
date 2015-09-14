<?php

namespace Tempo\Bundle\AppBundle\Tests\Manager;


use Tempo\Bundle\AppBundle\Manager\OrganizationManager;

class OrganizationManagerTest extends \PHPUnit_Framework_TestCase
{
    const ORGANIZATION_CLASS = 'Tempo\Bundle\AppBundle\Model\Project';
    private $em;
    private $repository;
    private $organizationManager;

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

        $this->repository = $this->getMockBuilder('Tempo\Bundle\AppBundle\Repository\OrganizationRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $domainManager = $this->getMockBuilder('Tempo\Bundle\ResourceExtraBundle\Manager\DomainManager')
            ->disableOriginalConstructor()
            ->getMock();

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

        $this->organizationManager = $this->createOrganizationManager($this->em, $domainManager, static::ORGANIZATION_CLASS);

    }

    protected function createOrganizationManager($objectManager, $domainManager, $userClass)
    {
        return new OrganizationManager(
            $objectManager, $domainManager, $userClass
        );
    }

    protected function getOrganization()
    {
        $projectClass = static::ORGANIZATION_CLASS;

        return new $projectClass();
    }

    public function testGetStatusProjects()
    {
        $this
            ->repository->expects($this->any())
            ->method('countProject')
            ->will($this->returnValue(['prj_close' => 0, 'prj_open' => 1 ]));

        $status = $this->organizationManager->getStatusProjects(1);
        $this->assertEquals(['open' => 1, 'close' => 0], $status);
    }
}
