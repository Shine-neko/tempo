<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RoomVoter extends ResourceVoter
{
    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        $supportedClass = 'Tempo\Bundle\AppBundle\Model\RoomInterface';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $project, array $attributes)
    {
        return parent::vote($token, $project, $attributes);
    }
}
