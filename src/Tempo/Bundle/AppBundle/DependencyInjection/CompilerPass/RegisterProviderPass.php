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
use Symfony\Component\DependencyInjection\Reference;

class RegisterProviderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('tempo.activity.provider_registry')) {
            return;
        }

        $providerRegistry = $container->getDefinition('tempo.activity.provider_registry');

        foreach ($container->findTaggedServiceIds('tempo.activity.provider') as $id => $attributes) {
            $providerRegistry->addMethodCall('registerProvider', array($id, new Reference($id)));
        }
    }
}