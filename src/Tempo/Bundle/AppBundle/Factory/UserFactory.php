<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Tempo\Bundle\AppBundle\Model\UserEmail;
use Tempo\Bundle\AppBundle\Model\UserInterface;

class UserFactory implements FactoryInterface
{
    /**
     * @var FactoryInterface
     */
    protected $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $user = new $this->className;
        $user
            ->addEmail(new UserEmail())
            ->addRole(UserInterface::ROLE_DEFAULT);

        return $user;
    }

}
