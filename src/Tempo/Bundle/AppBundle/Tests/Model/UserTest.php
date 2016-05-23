<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tests\Model;

use Tempo\Bundle\AppBundle\Model\UserEmail;
use Tempo\Bundle\AppBundle\Model\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testAddEmail()
    {
        $user = new User();
        $user->addEmail(new UserEmail('john.doe@tempo-project.org'));

        $this->assertCount(1, $user->getEmails());
        $this->assertEquals('john.doe@tempo-project.org', $user->getEmail());
    }

    public function testEmailIsMail()
    {
        $user = new User();
        $email = new UserEmail('marie.jane@tempo-project.org');
        $user->addEmail($email);

        $this->assertTrue($user->getEmails()->first()->isMain($email));
    }

    public function testChangeEmailMain()
    {
        $user = new User();

        $email1 = new UserEmail('marie.jane@tempo-project.org');
        $user->addEmail($email1);

        $email2 = new UserEmail('jane.marie@tempo-project.org');
        $email2->setMain(true);
        $user->addEmail($email2);

        $this->assertTrue($email2->isMain());
    }


    public function testDuplicateEmail()
    {
        $user = new User();

        $user->addEmail(new UserEmail('john.doe@tempo-project.org'));
        $user->addEmail(new UserEmail('john.doe@tempo-project.org'));

        $this->assertCount(1, $user->getEmails());
    }
}
