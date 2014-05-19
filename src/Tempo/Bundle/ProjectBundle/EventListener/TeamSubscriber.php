<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Tempo\Bundle\UserBundle\Manager\NotificationManager;
use Tempo\Bundle\ProjectBundle\TempoProjectEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TeamSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected $translator;

    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @param Translator          $translator
     * @param Router              $router
     * @param NotificationManager $notificationManager
     */
    public function __construct(Translator $translator, Router $router, NotificationManager $notificationManager)
    {
        $this->translator = $translator;
        $this->router = $router;
        $this->notificationManager = $notificationManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TempoProjectEvents::ORGANIZATION_ASSIGNING_USER => 'buildToOrganization',
            TempoProjectEvents::ORGANIZATION_DELETE_USER => 'buildToOrganization',

            TempoProjectEvents::PROJECT_ASSIGNING_USER => 'onBuildToProject',
            TempoProjectEvents::PROJECT_DELETE_USER => 'onBuildToProject',
        );
    }

    /**
     * @param \Tempo\Bundle\ProjectBundle\Event\TeamEvent $event
     */
    public function buildToOrganization($event)
    {
        if ('add' == $event->getType()) {
            $message = 'tempo.notification.organization.team.add.completed';
        } else {
            $message = 'tempo.notification.organization.team.deleted.completed';
        }

        $this->buildNotification($event, $message, 'organization_show');
    }

    /**
     * @param \Tempo\Bundle\ProjectBundle\Event\TeamEvent $event
     */
    public function buildToProject($event)
    {
        if ('add' == $event->getType()) {
            $message = 'tempo.notification.project.team.add.completed';
        } else {
            $message = 'tempo.notification.project.team.deleted.completed';
        }

        $this->buildNotification($event, $message, 'project_show');

    }

    /**
     * @param $model
     * @param $message
     * @param $route
     */
    protected function buildNotification($event, $message, $route)
    {
        $route  = $this->router->generate($route, array('slug' => $event->getModel()->getSlug() ));

        $message = $this->translator->trans($message, array('name' => $event->getModel(), 'TempoProject'));

        $this->notificationManager->create($event->getUserTo(), $message, $route);
    }
}
