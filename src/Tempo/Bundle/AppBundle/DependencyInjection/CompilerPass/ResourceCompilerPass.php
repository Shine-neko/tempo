<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ResourceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('stof_doctrine_extensions.listener.loggable');
        $definition->setClass('%tempo.listener.loggable.logger.class%');

        $lessAsseticFilter = $container->getDefinition('assetic.filter.less');
        $kernelRootDir = $container->getParameter('kernel.root_dir'). '/../web';
        $lessAsseticFilter->addMethodCall('addLoadPath', array($kernelRootDir));
        
        $container->setParameter('twig.form.resources', array_merge(
            array('TempoAppBundle:Form:phone_widget.html.twig'),
            $container->getParameter('twig.form.resources')
        ));
    }
}