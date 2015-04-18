<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Sylius\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;
use Doctrine\Common\Util\Inflector;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TempoAppExtension extends AbstractResourceExtension
{
    /**
     * @var string
     */
    protected $applicationName = 'tempo';

    /**
     * @var string
     */
    protected $configDirectory = '/../Resources/config';

    /**
     * @var array
     */
    protected $configFiles = array(
        'services',
        'doctrine_extensions',
        'providers',
        'security',
        'user',
        'events',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        list($config, $loader) = $this->configure(
            $config,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );

        $container->setParameter('sylius.locale', '%locale%');
        $container->setParameter('sylius.translation.mapping', '%sylius.translation.default.mapping%');
        $container->setParameter('hwi_oauth.connect', $container->getParameter('oauth.enabled'));
        $container->setParameter('tempo.week', $config['week']);

        $this->createManagerServices($container, $config);
        $this->createBackendServices($container, $config);
    }

    private function createManagerServices(ContainerBuilder $container, $config)
    {
        $models = array();
        $classes = $container->getParameter('sylius.config.classes');

        foreach ($classes as $key => $config) {

            $key = str_replace('tempo.', '', $key);

            if (isset($config['classes'])) {
                $models[$key] = $config['classes']['model'];
            } else {
                $models[$key] = $config['model'];
            }

            $manager = sprintf('Tempo\Bundle\AppBundle\Manager\%sManager', ucfirst(Inflector::classify($key)));

            if (!class_exists($manager)) {
                $manager = 'Tempo\Bundle\AppBundle\Manager\\ModelManager';
            }

            $container
                ->register('tempo.model_manager.' . $key, $manager)
                ->addArgument(new Reference('doctrine.orm.entity_manager'))
                ->addArgument(new Reference('tempo.domain_manager'))
                ->addArgument($models[$key]);
        }
    }

    public function createBackendServices(ContainerBuilder $container, $config)
    {
        foreach ($config['backend'] as $resourceName => $conf) {
            if (!isset($conf['controller'])) {
                $conf['controller'] = 'Tempo\Bundle\AppBundle\Controller\Backend\BackendController';
            }

            $container->setDefinition(
                'tempo.backend.controller.' . $resourceName,
                $this->getControllerDefinition($conf['controller'], $resourceName)
            );
        }
    }

    protected function getControllerDefinition($class, $resourceName)
    {
        $definition = new Definition($class);
        $definition
            ->setArguments(array($this->getConfigurationDefinition($resourceName)))
            ->addMethodCall('setContainer', array(new Reference('service_container')))
        ;

        return $definition;
    }

    protected function getConfigurationDefinition($resourceName)
    {
        $definition = new Definition('Sylius\Bundle\ResourceBundle\Controller\Configuration');
        $definition
            ->setFactory(array(
                new Reference('sylius.controller.configuration_factory'),
                'createConfiguration'
            ))
            ->setArguments(array('tempo', $resourceName, ''))
            ->setPublic(false)
        ;

        return $definition;
    }
}
