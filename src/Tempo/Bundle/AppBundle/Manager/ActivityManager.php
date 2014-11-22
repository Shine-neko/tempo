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

class ActivityManager extends BaseManager
{
    protected $user;


    public function setUser($user)
    {
        $this->user = $user;
    }

    public function build($target, $action, $data, $actor = null)
    {
        $shortNameTarget = (new \ReflectionObject($target))->getShortName();
        $shortNameData =  (new \ReflectionObject($data))->getShortName();

        if ($actor != null) {
            $this->user = $this->user;
        }

        $event = new Activity();

        $event
            ->setTarget($shortNameTarget)
            ->setAuthor($actor)
            ->setAction($action)
            ->setData($data)
            ->setType($shortNameData);

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
