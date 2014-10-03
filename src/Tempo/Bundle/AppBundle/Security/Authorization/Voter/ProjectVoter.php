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
use Symfony\Component\Security\Core\User\UserInterface;

class ProjectVoter implements VoterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';
    const ASSIGN = 'assign';

    protected $aclManager;

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
            self::EDIT,
            self::DELETE,
            self::ASSIGN,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        $supportedClass = 'Tempo\Bundle\AppBundle\Model\Project';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    /**
     * @var \Tempo\Bundle\AppBundle\Model\Project $project
     */
    public function vote(TokenInterface $token, $project, array $attributes)
    {
        // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($project))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // check if the voter is used correct, only allow one attribute
        // this isn't a requirement, it's just one easy way for you to
        // design your voter
        if(1 !== count($attributes)) {
            throw new \InvalidArgumentException(
                'Only one attribute is allowed for VIEW or EDIT'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];

        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // get current logged in user
        $user = $token->getUser();

        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        $role = $this->getRoleInProject($project->getTeam(), $token);

        switch($attribute) {
            case self::VIEW:
            case strtolower(self::VIEW):

                if ($role) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;

            case self::EDIT:
            case strtolower(self::EDIT):


            if ($role->getRole() <= 2) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }

    public function getRoleInProject($team, $token)
    {
        foreach($team as $user) {
            if ($user->getUser() == $token->getUser()) {
                return $user;
            }
        }
    }

    public function setAclManager($aclManager)
    {
        $this->aclManager = $aclManager;
        return $this;
    }
}
