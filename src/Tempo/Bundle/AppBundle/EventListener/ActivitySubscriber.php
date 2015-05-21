<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Event\AccessEvent;
use Tempo\Bundle\AppBundle\Manager\NotificationManager;
use Tempo\Bundle\AppBundle\Manager\ActivityManager;

class ActivitySubscriber implements EventSubscriberInterface
{
    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @param ActivityManager     $activityManager
     * @param NotificationManager $notificationManager
     */
    public function __construct(ActivityManager $activityManager, NotificationManager $notificationManager)
    {
        $this->activityManager = $activityManager;
        $this->notificationManager = $notificationManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TempoAppEvents::ORGANIZATION_ASSIGN_USER => array('accessNotification', 'createActivity'),
            TempoAppEvents::ORGANIZATION_DELETE_USER => array('accessNotification', 'createActivity'),

            TempoAppEvents::PROJECT_ASSIGN_USER => array('accessNotification', 'createActivity'),
            TempoAppEvents::PROJECT_DELETE_USER => array('accessNotification', 'createActivity'),

            TempoAppEvents::COMMENT_CREATE_SUCCESS => array('createActivity')
        );
    }

    /**
     * @param $event
     * @return string
     */
    protected function getModelName($event)
    {
        $modelName = ((new \ReflectionClass($event->getSubject()))->getShortName());
        return strtolower($modelName);
    }

    /**
     * @param AccessEvent $event
     */
    public function accessNotification(AccessEvent $event)
    {
        $modelName = $this->getModelName($event);
        $message = sprintf('tempo.notification.%s.team.add.completed', $modelName);

        $notification = $this->notificationManager
            ->create($event->getUserTo(), $message, $event->getSubject());

        $this->notificationManager->save($notification);
    }

    /**
     * @param $event
     */
    public function createActivity($event)
    {
        $modelName = $this->getModelName($event);
        $resource = $event->getSubject();
        $activity = $this->activityManager->getRepository()->createNew();

        switch($event->getName()) {
            case TempoAppEvents::ORGANIZATION_ASSIGN_USER:
            case TempoAppEvents::PROJECT_ASSIGN_USER:
                $message = sprintf('tempo.activity.events.%s.joined', $modelName);
                break;
            case TempoAppEvents::COMMENT_CREATE_SUCCESS:
                $message = sprintf('tempo.activity.events.commented', $modelName);
                $activity->setProject($resource->getProject());
                break;
        }

        if (method_exists($resource, 'getAuthor')) {
            $author = $resource->getAuthor();
        } elseif (method_exists($event->getSubject(), 'getUser')) {
            $author = $resource->getUser();
        }

        $activity
            ->setAuthor($author)
            ->setData($resource)
            ->setTarget($resource)
            ->setAction($message);

        $this->activityManager->save($activity);
    }
}
