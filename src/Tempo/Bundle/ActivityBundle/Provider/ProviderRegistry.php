<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ActivityBundle\Provider;

class ProviderRegistry
{
    /**
     * Providers.
     *
     * @var array
     */
    protected $providers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->providers = array();
    }

    /**
     * Get an array of all registered provider.
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Register a provider for given provider name.
     *
     * @param string            $namespace
     * @param ProviderInterface $provider
     */
    public function registerProvider($name, $provider)
    {
        if ($this->hasProvider($name)) {
            throw new \InvalidArgumentException(sprintf('Provider "%s" has been already registered', $name));
        }

        $this->providers[$name] = $provider;
    }

    /**
     * Unregister provider with given name.
     *
     * @param string $name
     */
    public function unregisterProvider($name)
    {
        if (!$this->hasProvider($name)) {
            throw new \InvalidArgumentException(sprintf('Provider "%s" does not exist', $name));
        }

        unset($this->providers[$name]);
    }

    /**
     * Has provider registered to given name?
     *
     * @param string $name
     *
     * @return Boolean
     */
    public function hasProvider($namespace)
    {
        return isset($this->providers[$namespace]);
    }

    /**
     * Get provider for given name.
     *
     * @param string $name
     *
     * @return ProviderInterface
     */
    public function getProvider($name)
    {
        if (!$this->hasProvider($name)) {
            throw new \InvalidArgumentException(sprintf('Provider "%s" does not exist', $name));
        }

        return $this->provider[$name];
    }
}
