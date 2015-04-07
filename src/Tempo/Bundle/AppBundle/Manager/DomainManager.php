<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Resource\Event\ResourceEvent;

/**
 * Domain Manager
 *
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 * @author Jérémy Leherpeur <jeremy@leherpeur.net>
 */

class DomainManager
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var Collection
     */

    protected $parameters;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(ObjectManager $objectManager, EventDispatcherInterface $eventDispatcher, $parameters)
    {
        $this->objectManager    = $objectManager;
        $this->eventDispatcher  = $eventDispatcher;
        $this->parameters       = $parameters;
    }

    /**
     * @param $resource
     * @param $name
     * @param string $prefix
     * @return Event
     */
    protected function dispatchEvent($resource, $name, $prefix = 'tempo')
    {
        return $this->eventDispatcher->dispatch(
            $this->getEventName($resource, $name, $prefix),
            new ResourceEvent($resource)
        );
    }

    /**
     * @param $resource
     * @param $name
     * @param $prefix
     * @return string
     */
    protected function getEventName($resource, $name, $prefix)
    {
        $resourceName = (new \ReflectionClass($resource))->getShortName();

        return sprintf('%s.%s.%s', $prefix, strtolower($resourceName), $name);
    }

    public function flush()
    {
        $this->objectManager->flush();
    }

    /**
     * @param $resource
     * @return Event
     */
    public function create($resource, $flush = true)
    {
        $event = $this->dispatchEvent($resource, 'pre_create');

        if ($event->isPropagationStopped()) {
            return $event;
        }

        $this->objectManager->persist($resource);
        if ($flush) {
            $this->objectManager->flush();
        }

        $this->dispatchEvent($resource, 'post_create');
    }

    /**
     * @param $resource
     * @return Event
     */
    public function update($resource, $flush = true)
    {
        $event = $this->dispatchEvent($resource, 'pre_update');

        if ($event->isPropagationStopped()) {
            return  $event;
        }

        $this->objectManager->persist($resource);
        if ($flush) {
            $this->objectManager->flush();
        }

        $this->dispatchEvent($resource, 'post_update');
    }

    /**
     * @param $resource
     * @return Event
     */
    public function delete($resource, $flush = true)
    {
        $event = $this->dispatchEvent($resource, 'pre_delete');

        if ($event->isPropagationStopped()) {
            return  $event;
        }

        $this->objectManager->remove($resource);
        if ($flush) {
            $this->objectManager->flush();
        }

        $this->dispatchEvent($resource, 'post_delete');
    }
}
