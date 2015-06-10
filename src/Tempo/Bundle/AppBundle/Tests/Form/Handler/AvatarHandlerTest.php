<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tests\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tempo\Bundle\AppBundle\Form\Handler\AvatarHandler;
use Tempo\Bundle\AppBundle\Model\User;

class AvatarHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $domainManager;
    protected $form;

    protected function setUp()
    {
        $this->domainManager = $this->getMockBuilder('Tempo\Bundle\AppBundle\Manager\DomainManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->form = $this->getMockBuilder('Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock();

        copy(realpath(__DIR__ . '/../../Fixtures/assets/cats.jpeg'), sys_get_temp_dir(). '/cats.jpeg');
    }

    public function testGetPath()
    {
        $request = new Request();
        $avatartHandler = new AvatarHandler($request, $this->form, $this->domainManager);
        $avatartHandler->setPath('uploads');

        $this->assertEquals($avatartHandler->getPath(), 'uploads/avatars/');
    }

    public function testOnSuccess()
    {
        $avatarHandler = new AvatarHandler(new Request(), $this->form, $this->domainManager);
        $avatarHandler->setPath(sys_get_temp_dir(). '/uploads');
        $resource = new User();

        $uploadFile = new UploadedFile(
            sys_get_temp_dir() . '/cats.jpeg',
            'cats.jpeg',
            null,
            filesize(sys_get_temp_dir() . '/cats.jpeg'),
            UPLOAD_ERR_OK,
            true
        );

        $reflector = new \ReflectionMethod($avatarHandler, 'uploading');
        $reflector->setAccessible(true);

        $response = $reflector->invoke($avatarHandler, $resource, $uploadFile);
        $this->assertEquals($response, 1);
    }

    public function testRemoveImage()
    {
        $request = new Request(array(), array('delete' => true));
        $avatarHandler = new AvatarHandler($request, $this->form, $this->domainManager);
        $avatarHandler->setPath(sys_get_temp_dir(). '/uploads');
        copy(realpath(__DIR__ . '/../../Fixtures/assets/cats.jpeg'), sys_get_temp_dir(). '/cats-eyes.jpeg');

        $reflector = new \ReflectionMethod($avatarHandler, 'deleteFile');
        $reflector->setAccessible(true);
        $response = $reflector->invoke($avatarHandler, new User());

        $this->assertEquals($response, 2);
    }

}