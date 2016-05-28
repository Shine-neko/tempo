<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Manager;

use Tempo\Bundle\AppBundle\Model\User;
use Tempo\Bundle\ResourceExtraBundle\Manager\ModelManager;

/**
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class UserManager extends ModelManager
{
    /**
     * Finds a user either by email, or username
     *
     * @param string $usernameOrEmail
     *
     * @return User
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmails(array($usernameOrEmail));
        }

        return $this->findUserBy(array('username' => $usernameOrEmail));
    }

    public function findUserByEmails(array $emails)
    {
        return $this->getRepository()->findUserByEmails($emails);
    }

    public function findUserBy($criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    public function nbTotalUser()
    {
        return $this->getRepository()->totalUser();
    }
}
