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

interface ActivityProviderInterface extends ResourceInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set provider
     *
     * @param  ProjectProviderInterface $provider
     * @return Activity
     */
    public function setProvider(ProjectProviderInterface $provider);

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider();

    /**
     * Set message
     *
     * @param  string   $message
     * @return Activity
     */
    public function setMessage($message);

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Set headers
     *
     * @param  array    $headers
     * @return Activity
     */
    public function setHeaders($headers);

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Set parameters
     *
     * @param  array    $parameters
     * @return Activity
     */
    public function setParameters($parameters);

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters();

    /**
     * Set datetime
     *
     * @param  \DateTime $datetime
     * @return Activity
     */
    public function setCreatedAt(\DateTime $datetime);

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set datetime
     *
     * @param  \DateTime $datetime
     * @return Activity
     */
    public function setDeletedAt(\DateTime $datetime);

    /**
     * @return Object
     */
    public function getData();
}
