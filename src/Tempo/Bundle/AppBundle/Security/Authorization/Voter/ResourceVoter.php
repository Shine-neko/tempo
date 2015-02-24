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

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Tempo\Bundle\AppBundle\Model\UserInterface;

class ResourceVoter implements VoterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';
    const ASSIGN = 'assign';
    const DELETE_ASSIGN = 'delete_assign';

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
            self::EDIT,
            self::DELETE,
            self::ASSIGN,
            self::DELETE_ASSIGN,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $resource, array $attributes)
    {
        if (!method_exists($resource, 'getMembers') && !$this->supportsClass(get_class($resource))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // check if the voter is used correct, only allow one attribute
        // this isn't a requirement, it's just one easy way for you to
        // design your voter
        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException(
                'Only one attribute is allowed for VIEW or EDIT'
            );
        }

        // get current logged in user
        $user = $token->getUser();

        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        if($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN') ) {
            return VoterInterface::ACCESS_GRANTED;
        }

        $member = $resource->getMemberByUser($user);

        if (null === $member) {
            return VoterInterface::ACCESS_DENIED;
        }

        foreach ($attributes as $attribute) {
            $this->checkAttribute($resource, $attribute, $member);
        }
    }

    public function checkAttribute($resource, $attribute, $member)
    {
        switch ($attribute) {
            case self::EDIT:
            case self::DELETE:
            case self::ASSIGN:
            case self::DELETE_ASSIGN:
                // we assume that our data object has a method getOwner() to
                // get the current owner user entity for this data object
                if ($member->getLabel() == AccessInterface::TYPE_OWNER) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
    }
}
