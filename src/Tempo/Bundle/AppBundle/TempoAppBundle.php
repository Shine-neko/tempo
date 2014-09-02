<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass\OverrideServiceCompilerPass;
use Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass\ProjectTabRegistryCompilerPass;
use Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass\RegisterProviderPass;


/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class TempoAppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OverrideServiceCompilerPass());
        $container->addCompilerPass(new RegisterProviderPass());
        $container->addCompilerPass(new ProjectTabRegistryCompilerPass());
    }
}
