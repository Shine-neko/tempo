<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Tempo\Bundle\AppBundle\Behavior\TimestampTrait;

/**
 * Activity
 *
 */
class ActivityProvider implements ActivityProviderInterface, ResourceInterface
{
    use TimestampTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     *
     */
    protected $provider;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $parameters;

    public function __toString()
    {
        return $this->getMessage();
    }

    /**
     * {inheritedDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {inheritedDoc}
     */
    public function setProvider(ProjectProviderInterface $provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * {inheritedDoc}
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {inheritedDoc}
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {inheritedDoc}
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * {inheritedDoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->parameters;
    }
}
