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

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Routing\RouterInterface;
use Tempo\Bundle\UserBundle\Manager\NotificationManager;
use Tempo\Bundle\AppBundle\TempoProjectEvents;
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
     * @param TranslatorInterface $translator
     * @param RouterInterface     $router
     * @param NotificationManager $notificationManager
     */
    public function __construct(TranslatorInterface $translator, RouterInterface $router, NotificationManager $notificationManager)
    {
        $this->translator = $translator;
        $this->router = $router;
        $this->notificationManager = $notificationManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TempoProjectEvents::ORGANIZATION_ASSIGN_USER => 'buildNotification',
            TempoProjectEvents::ORGANIZATION_DELETE_USER => 'buildNotification',

            TempoProjectEvents::PROJECT_ASSIGN_USER => 'buildNotification',
            TempoProjectEvents::PROJECT_DELETE_USER => 'buildNotification',
        );
    }

    public function buildNotification($event)
    {
        $modelName = strtolower((new \ReflectionClass($event->getModel()))->getShortName());
        $message = sprintf('tempo.notification.%s.team.add.completed', $modelName);

        $route  = $this->router->generate($modelName. '_show', array(
            'slug' => $event->getModel()->getSlug()
        ));
        $message = $this->translator->trans($message, array('name' => $event->getModel(), 'TempoProject'));

        $this->notificationManager->create($event->getUserTo(), $message, $route);
    }
}
