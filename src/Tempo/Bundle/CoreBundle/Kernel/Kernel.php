<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\Kernel;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends BaseKernel
{
    const VERSION = '0.1.0-dev';
    const VERSION_ID = '00100';
    const MAJOR_VERSION = '0';
    const MINOR_VERSION = '1';
    const RELEASE_VERSION = '0';
    const EXTRA_VERSION = 'DEV';

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new \FOS\UserBundle\FOSUserBundle(),
            new \FOS\RestBundle\FOSRestBundle(),
            new \FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new \Sylius\Bundle\SettingsBundle\SyliusSettingsBundle(),
            new \Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new \Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new \Knp\Bundle\TimeBundle\KnpTimeBundle(),

            new \HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new \Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new \Liip\ImagineBundle\LiipImagineBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \JMS\SerializerBundle\JMSSerializerBundle($this),
            new \Problematic\AclManagerBundle\ProblematicAclManagerBundle(),
            new \Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),

            new \WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new \Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),

            //Tempo
            new \Tempo\Bundle\CoreBundle\TempoCoreBundle(),
            new \Tempo\Bundle\MainBundle\TempoMainBundle(),
            new \Tempo\Bundle\UserBundle\TempoUserBundle(),
            new \Tempo\Bundle\ProjectBundle\TempoProjectBundle(),
            new \Tempo\Bundle\ActivityBundle\TempoActivityBundle(),
            new \Tempo\Bundle\JsConfigurationBundle\TempoJsConfigurationBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new \Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new \Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
            $bundles[] = new \Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();

            if(class_exists('Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle')) {
                $bundles[] = new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            }
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}