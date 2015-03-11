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

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tempo\Bundle\AppBundle\Model\Activity;
use Tempo\Bundle\AppBundle\Model\ProjectInterface;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Manager\NotificationManager;
use Tempo\Bundle\AppBundle\Manager\ActivityManager;

class AccessSubscriber implements EventSubscriberInterface
{
    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @param RouterInterface     $router
     * @param ActivityManager     $activityManager
     * @param NotificationManager $notificationManager
     */
    public function __construct(RouterInterface $router, ActivityManager $activityManager, NotificationManager $notificationManager)
    {
        $this->router = $router;
        $this->activityManager = $activityManager;
        $this->notificationManager = $notificationManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TempoAppEvents::ORGANIZATION_ASSIGN_USER => 'accessNotification',
            TempoAppEvents::ORGANIZATION_DELETE_USER => 'accessNotification',

            TempoAppEvents::PROJECT_ASSIGN_USER => 'accessNotification',
            TempoAppEvents::PROJECT_DELETE_USER => 'accessNotification',
        );
    }

    /**
     * @param $event
     */
    public function accessNotification($event)
    {
        $modelName = strtolower((new \ReflectionClass($event->getModel()))->getShortName());
        $message = sprintf('tempo.notification.%s.team.add.completed', $modelName);
        $resource = $event->getModel();

        $route  = $this->router->generate($modelName. '_show', array('slug' => $resource->getSlug()));
        $data = array('resource' => $resource, 'name' => $resource->getName());

        if($resource instanceof ProjectInterface){
            $route  = $this->router->generate($modelName. '_show', array('slug' => $resource->getFullSlug()));
        }

        $notification = $this->notificationManager
            ->create($event->getUserTo(), $message, $data)
                ->setLink($route);

        $this->notificationManager->save($notification);

        var_dump($event->getName()); exit;

        if ($event->getName() == 'tempo.project.team.add.completed') {
            $activity = (new Activity())
                ->setAuthor($event->getUserTo())
                ->setData($data)
                ->setTarget($resource)
                ->setLink($route)
                ->setAction(sprintf('tempo.activity.events.%s.joined', $modelName));

            $this->activityManager->save($activity);
        }
    }
}
