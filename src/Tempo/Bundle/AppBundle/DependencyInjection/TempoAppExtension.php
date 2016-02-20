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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Tempo\Bundle\ResourceExtraBundle\DependencyInjection\TempoResourceExtraExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TempoAppExtension extends TempoResourceExtraExtension
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
        $config = $this->processConfiguration(new Configuration(), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $this->registerResources($this->applicationName, $config['driver'], array(), $container);

        foreach($this->configFiles as $configFile) {
            $loader->load($configFile);
        }

        $container->setParameter('hwi_oauth.connect', $container->getParameter('oauth.enabled'));
        $container->setParameter('tempo.week', $config['week']);

    }
}
