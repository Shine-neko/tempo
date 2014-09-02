<?php

namespace Tempo\Bundle\AppBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ProjectTabRegistryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('tempo.project.tabProvidersRegistry')) {
            return;
        }

        $definition = $container->getDefinition(
            'tempo.project.tabProvidersRegistry'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'tempo.project.show.tab'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addProvider',
                array(new Reference($id))
            );
        }
    }
}