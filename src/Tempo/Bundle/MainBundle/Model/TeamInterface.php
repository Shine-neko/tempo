<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Model;


interface TeamInterface
{
    const TYPE_ADMIN = 1;
    const TYPE_MODERATOR = 2;
    const TYPE_USER = 3;

    public function setCreatedAt(\DateTime $createdAt);
    public function getCreatedAt();
}