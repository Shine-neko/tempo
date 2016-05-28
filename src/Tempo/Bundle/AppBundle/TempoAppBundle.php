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
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass\ResourceCompilerPass;
use Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass\RegisterProviderPass;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */

class TempoAppBundle extends AbstractResourceBundle
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
    public function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM
        );
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
