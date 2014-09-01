<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ProjectBundle\Manager;

use Tempo\Bundle\MainBundle\Manager\BaseManager;
use Tempo\Bundle\ProjectBundle\Model\ProjectProviderInterface;
use Tempo\Bundle\ProjectBundle\Model\ActivityProviderInterface;

class ActivityProviderManager extends BaseManager
{
    /**
     * @param ActivityProviderInterface $activity
     * @param ProjectProviderInterface $projectProvider
     * @return ActivityProviderInterface
     */
    public function addActivity(ActivityProviderInterface $activity, ProjectProviderInterface $projectProvider)
    {
        $activity->setProvider($projectProvider);
        $this->save($activity);

        return $activity;
    }
}