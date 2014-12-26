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
use Tempo\Bundle\AppBundle\Model\User;

class ActivityManager extends BaseManager
{
    /**
     * @var User;
     */
    protected $user;

    /**
     * @param User $user
     */
    public function setUser(User $user)
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
     * @param $type
     * @param $user
     */
    public function findByUser($type = null, $user = null)
    {
        return $this->getRepository()->findLastActivities($type, $user);
    }
}
