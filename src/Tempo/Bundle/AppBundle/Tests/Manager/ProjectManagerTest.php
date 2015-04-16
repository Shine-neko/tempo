<?php

namespace Tempo\Bundle\AppBundle\Tests\Manager;

use Tempo\Bundle\AppBundle\Manager\ProjectManager;


class ProjectManagerTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_CLASS = 'Tempo\Bundle\AppBundle\Model\Project';
    private $em;
    private $projectManager;

    public function setUp()
    {
        $this->em = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'persist', 'flush', 'remove'), array(), '', false);

        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $domainManager = $this->getMockBuilder('Tempo\Bundle\AppBundle\Manager\DomainManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->em->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::PROJECT_CLASS))
            ->will($this->returnValue($this->repository));
        $this->em->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::PROJECT_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::PROJECT_CLASS));

        $this->projectManager = $this->createProjectManager($this->em, $domainManager, static::PROJECT_CLASS);

    }

    protected function createProjectManager($objectManager, $domainManager, $userClass)
    {
        return new ProjectManager($objectManager, $domainManager, $userClass);
    }

    protected function getProject()
    {
        $projectClass = static::PROJECT_CLASS;

        return new $projectClass();
    }

    public function testNbTotalProject()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
