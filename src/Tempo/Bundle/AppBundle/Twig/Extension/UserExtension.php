<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Twig\Extension;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Tempo\Bundle\AppBundle\Manager\NotificationManager;
use Tempo\Bundle\AppBundle\Model\Notification;

class UserExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    private $notificationManager;

    /**
     * @param $notificationManager
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator, NotificationManager $notificationManager)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->notificationManager = $notificationManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array( );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'user_notifications' => new \Twig_Function_Method($this, 'getNotifications'),
            'read_notification' => new \Twig_Function_Method($this, 'readNotification'),
            'link_notification' => new \Twig_Function_Method($this, 'linkNotification'),
        );
    }

    /**
     * @param $userId
     */
    public function getNotifications($userId)
    {
        return $this->notificationManager->getNotifications($userId, Notification::STATE_UNREAD)->getQuery()->execute();
    }

    public function readNotification($notification)
    {
        return $this->translator->trans($notification->getMessage(), array('%name%' => $notification->getData()));
    }

    public function linkNotification($notification)
    {
        $resource = $notification->getData();
        $shortName = strtolower((new \ReflectionClass($resource))->getShortName());

        return $this->router->generate($shortName.'_show', array(
            'slug' => $shortName == 'Project' ? $resource->getFullSlug() : $resource->getSlug(  )
        )). '#'.$resource->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_extension';
    }
}
