<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Model;

interface SessionInterface
{
    /**
     * Get ID
     */
    public function getId();

    /**
     * @return string
     */
    public function getBrowser();

    /**
     * @param string $browser
     */
    public function setBrowser($browser);

    /**
     * @return string
     */
    public function getLocation();

    /**
     * @param string $location
     */
    public function setLocation($location);


    /**
     * @return User
     */
    public function getUser();

    /**
     * @param User $user
     */
    public function setUser($user);
}
