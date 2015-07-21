<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tests\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Tempo\Bundle\AppBundle\Security\Authorization\Voter\RoomVoter;
use Tempo\Bundle\AppBundle\Security\Authorization\Voter\ResourceVoter;

class ResourceVoterTest extends \PHPUnit_Framework_TestCase
{
    public function testSupportsClass()
    {
        $voter = new RoomVoter();
        $this->assertTrue($voter->supportsClass('Tempo\Bundle\AppBundle\Model\Room'));
    }

    public function testCheckAttribute()
    {
        $access = $this->getAccess();
        $access->expects($this->any())
            ->method('getLabel')
            ->will($this->returnValue('owner'));
        $this->assertEquals($this->getResourceVoter()->checkAttribute('delete', $access), null);
    }

    public function testVote()
    {
        $access = $this->getAccess();
        $resource  = $this->getResourceVoter();

        $user = $this
            ->getMockBuilder('Tempo\Bundle\AppBundle\Model\UserInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $token = $this
               ->getMockBuilder('Symfony\Component\Security\Core\Authentication\Token\TokenInterface')
               ->disableOriginalConstructor()
               ->getMock();

        $token->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($user));

        $room =  $this
            ->getMockBuilder('Tempo\Bundle\AppBundle\Model\Room')
            ->disableOriginalConstructor()
            ->getMock();

        $room->expects($this->atLeastOnce())
            ->method('getMemberByUser')
            ->will($this->returnValue($access));

        $this->assertEquals(
            $resource->vote($token, $room, array('VIEW')),
            VoterInterface::ACCESS_GRANTED
        );
    }

    public function getAccess()
    {
        return $this
            ->getMockBuilder('Tempo\Bundle\AppBundle\Model\Access')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getResourceVoter()
    {
        return new ResourceVoter();
    }
}
