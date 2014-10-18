<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Security;

use FOS\UserBundle\Security\UserProvider as BaseUserProvider;


class UserProvider extends BaseUserProvider
{
    public function getUsernameForApiKey($apiToken)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $user = $this->userManager->findUserBy(array('token' => $apiToken));

        return $user;
    }
}