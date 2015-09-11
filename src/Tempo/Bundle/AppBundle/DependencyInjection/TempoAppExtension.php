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
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Doctrine\Common\Util\Inflector;
use Tempo\Bundle\AppBundle\Util\ClassUtils;

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
        'services.xml',
        'doctrine_extensions.xml',
        'providers.xml',
        'security.xml',
        'user.xml',
        'events.xml',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->configure(
            $config,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );

        $container->setParameter('sylius.locale', '%locale%');
        $container->setParameter('hwi_oauth.connect', $container->getParameter('oauth.enabled'));
        $container->setParameter('tempo.week', $config['week']);

        $this->createManagerServices($container);
        $this->createAdminServices($container, $config);
    }

    private function createManagerServices(ContainerBuilder $container)
    {
        $classes = $container->getParameter('sylius.config.classes')['default'];

        foreach ($classes as $config) {

            $className = ClassUtils::getShortName($config['model'], false);

            $model = $config['model'];
            $manager = sprintf('Tempo\Bundle\AppBundle\Manager\%sManager', ucfirst($className));


            if (!class_exists($manager)) {
                $manager = 'Tempo\Bundle\AppBundle\Manager\\ModelManager';
            }

            $container
                ->register('tempo.model_manager.' . ClassUtils::uncamel($className), $manager)
                ->addArgument(new Reference('doctrine.orm.entity_manager'))
                ->addArgument(new Reference('tempo.domain_manager'))
                ->addArgument($model);
        }
    }

    public function createAdminServices(ContainerBuilder $container, $config)
    {
        foreach ($config['admin'] as $resourceName => $conf) {
            if (!isset($conf['controller'])) {
                $conf['controller'] = 'Tempo\Bundle\AppBundle\Controller\Admin\AdminController';
            }

            $container->setDefinition(
                'tempo.admin.controller.' . $resourceName,
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
