<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Tests\Security;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Security\TokenAuthenticator;
use Tempo\Bundle\AppBundle\Model\User;


class TokenAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    const API_TOKEN = 'ae4c20437c29c5598e7038b69637017347b43994';

    private $tokenAuthenticator;
    private $userProvider;

    protected function setUp()
    {
        $httpUtils = $this->getMock('Symfony\Component\Security\Http\HttpUtils');
        $this->userProvider = $this->getMockBuilder('Tempo\Bundle\AppBundle\Security\UserProvider')
            ->disableOriginalConstructor()
            ->getMock();


        $this->tokenAuthenticator = new TokenAuthenticator($httpUtils, $this->userProvider);
    }

    public function testCreateToken()
    {
        $request = new Request(array('access_token' => self::API_TOKEN));
        $token = $this->tokenAuthenticator->createToken($request, 'api');

        $this->assertEquals(self::API_TOKEN, $token->getCredentials());
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\BadCredentialsException
     */
    public function testApiNotFound()
    {
        $this->tokenAuthenticator->createToken(new Request(), 'api');
    }

    public function testAuthenticateToken()
    {
        $user = (new User())
            ->setUsername('admin');

        $this->userProvider->expects($this->any())
            ->method('getUsernameForApiKey')
            ->with(self::API_TOKEN)
            ->will($this->returnValue($user));

        $request = new Request(array('access_token' => self::API_TOKEN));
        $token = $this->tokenAuthenticator->createToken($request, 'api');
        $this->tokenAuthenticator->authenticateToken($token, $this->userProvider, 'api');

    }
}