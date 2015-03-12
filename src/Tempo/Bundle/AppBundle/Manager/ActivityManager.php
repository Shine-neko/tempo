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

use Tempo\Bundle\AppBundle\Model\Activity;
use Tempo\Bundle\AppBundle\Model\UserInterface;

class ActivityManager extends ModelManager
{
    /**
     * @var UserInterface;
     */
    protected $user;

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

    public function build($target, $action, $data, $author = null)
    {
        $shortNameTarget = (new \ReflectionObject($target))->getShortName();

        if ($author === null) {
            $author = $this->user;
        }

        $event = new Activity();
        $event
            ->setTarget($shortNameTarget)
            ->setAuthor($author)
            ->setAction($action)
            ->setData($data);

        $this->save($event);
    }

    /**
     * @param $user
     */
    public function getActivityActions($user)
    {
        return $this->getRepository()->getUserActivites($user);
    }
}
