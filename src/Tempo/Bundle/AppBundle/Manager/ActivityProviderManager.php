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

use Tempo\Bundle\AppBundle\Model\ProjectProviderInterface;
use Tempo\Bundle\AppBundle\Model\ActivityProviderInterface;
use Tempo\Bundle\ResourceExtraBundle\Manager\ModelManager;

class ActivityProviderManager extends ModelManager
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

    /**
     * @param array $criteria
     * @return mixed
     */
    public function getActivities($criteria)
    {
        if (null !== $criteria['activity'] || null !== $criteria['activity_provider']) {
            unset($criteria['createdAt']);
        }

        return $this->getRepository()->findActivities($criteria);
    }

}