<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Manager;

use Tempo\Bundle\CoreBundle\Manager\BaseManager;
use Tempo\Bundle\ProjectBundle\Model\ProjectProviderInterface;
use Tempo\Bundle\ActivityBundle\Model\ActivityProviderInterface;

class ActivityProviderManager extends BaseManager
{
    public function addActivity(ActivityProviderInterface $activity, ProjectProviderInterface $projectProvider)
    {
        $activity->setProvider($projectProvider);
        $this->save($activity);

        return $activity;
    }
}