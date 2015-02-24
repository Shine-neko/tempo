<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Behavior;

use Tempo\Bundle\AppBundle\Model\Access;
use Tempo\Bundle\AppBundle\Model\User;

Trait AccessTrait
{
    /**
     * @param $user
     * @param $label
     * @return $this
     */
    public function addAccess($user, $label = Access::TYPE_COLLABORATOR)
    {
        $this->members[] = (new Access())
            ->setSource($this)
            ->setUser($user)
            ->setLabel($label);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param  User $user
     * @return null
     */
    public function getMemberByUser(User $user)
    {
        foreach ($this->members as $member) {
            if ($user === $member->getUser()) {
                return $member;
            }
        }

        return;
    }
}
