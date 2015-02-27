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

interface AccessInterface
{
    const TYPE_OWNER = 'owner';
    const TYPE_COLLABORATOR = 'collaborator';
    const TYPE_PARTNER = 'partner';

    /**
     * @param \DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param User $user
     * @return self
     */
    public function setUser(User $user);

    /**
     * @return mixed
     */
    public function getUser();

    /**
     * @param $label
     * @return self
     */
    public function setLabel($label);

    /**
     * @return string
     */
    public function getLabel();
}
