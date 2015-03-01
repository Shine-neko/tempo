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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Manager\NotificationManager;

class AccessSubscriber implements EventSubscriberInterface
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
            TempoAppEvents::ORGANIZATION_ASSIGN_USER => 'buildNotification',
            TempoAppEvents::ORGANIZATION_DELETE_USER => 'buildNotification',

            TempoAppEvents::PROJECT_ASSIGN_USER => 'buildNotification',
            TempoAppEvents::PROJECT_DELETE_USER => 'buildNotification',
        );
    }

    public function buildNotification($event)
    {
        $modelName = strtolower((new \ReflectionClass($event->getModel()))->getShortName());
        $message = sprintf('tempo.notification.%s.team.add.completed', $modelName);
        $resource = $event->getModel();

        $route  = $this->router->generate($modelName. '_show', array('slug' => $resource->getSlug() ));
        $data = array('resource' => $resource, 'name' => $resource->getName());

        $notification = $this->notificationManager
            ->create($event->getUserTo(), $message, $data)
                ->setLink($route);

        $this->notificationManager->save($notification);
    }
}
