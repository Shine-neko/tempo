<?php

namespace Tempo\Bundle\ProjectBundle\Tests\Manager;

use Tempo\Bundle\ProjectBundle\Manager\ProjectManager;


class ProjectManagerTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_CLASS = 'Tempo\Bundle\ProjectBundle\Entity\Project';

    public function setUp()
    {
        $this->em = $this->getMock('\Doctrine\ORM\EntityManager',
            array('getRepository', 'getClassMetadata', 'persist', 'flush', 'remove'), array(), '', false);

        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');

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

        $this->projectManager = $this->createProjectManager($this->em, static::PROJECT_CLASS);

    }

    protected function createProjectManager($objectManager, $userClass)
    {
        return new ProjectManager($objectManager, $userClass);
    }

    protected function getProject()
    {
        $projectClass = static::PROJECT_CLASS;

        return new $projectClass();
    }


    public function testDeleteProject()
    {
        $project = $this->getProject();
        $this->em
            ->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($project));
        $this->em->expects($this->once())->method('flush');

        $this->projectManager->remove($project);
    }
}
