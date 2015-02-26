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
use Sylius\Bundle\ResourceBundle\DependencyInjection\AbstractResourceExtension;

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
        'orm',
        'providers',
        'security',
        'user',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configure(
            $config,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );

        $container->setParameter('sylius.locale', '%locale%');
        $container->setParameter('sylius.translation.mapping', '%sylius.translation.default.mapping%');
        $container->setParameter('tempo_app.week', $config[0]['week']);
    }
}
