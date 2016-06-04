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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass\ResourceCompilerPass;
use Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass\RegisterProviderPass;
use Tempo\Bundle\ResourceExtraBundle\TempoResourceExtraBundle;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class TempoAppBundle extends TempoResourceExtraBundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ResourceCompilerPass());
        $container->addCompilerPass(new RegisterProviderPass());
    }

    /**
     * {@inheritDoc}
     */
    protected function getDoctrineMappingDirectory()
    {
        return 'model';
    }

    /**
     * {@inheritDoc}
     */
    protected function getModelNamespace()
    {
        return 'Tempo\Bundle\AppBundle\Model';
    }
}
