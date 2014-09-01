<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Manager;

use Tempo\Bundle\CoreBundle\Manager\BaseManager;
use Tempo\Bundle\MainBundle\Entity\Activity;

class ActivityManager extends BaseManager
{
    public function build($actor, $action, $target = '')
    {
        $reflected =  new \ReflectionObject($target);

        $event = new Activity();
        $event
            ->setAuthor($actor)
            ->setAction($action)
            ->setTarget($target)
            ->setTargetType($reflected->getShortName());

        $this->save($event);
    }

    /**
     * @param $type
     * @param SecurityContext $user
     */
    public function findByUser($type = null, $user = null)
    {
        return $this->repository->findLastActivities($type, $user);
    }
}