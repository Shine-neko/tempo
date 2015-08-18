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

use Tempo\Bundle\AppBundle\Model\ProjectProvider;


/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
class ProjectProviderManager extends ModelManager
{
    public function getProviders($projects)
    {
        $providers = array();

        foreach ($projects as $project) {
            foreach ($project->getProviders() as $provider) {
                $providers[$provider->getName()] = $provider;
            }
        }

        return $providers;
    }

    public function createProvider($name, $project)
    {
        $projectProvider = new ProjectProvider();
        $projectProvider
            ->setName($name)
            ->setProject($project)
            ->setToken(sha1(uniqid(rand(), true)))
            ->setState(ProjectProviderInterface::STATE_ACTIVE);

        return $projectProvider;
    }
}