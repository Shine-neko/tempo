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

use Symfony\Component\Translation\TranslatorInterface;

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
    public function __construct(TranslatorInterface $translator, $notificationManager)
    {
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
        );
    }

    /**
     * @param $userId
     */
    public function getNotifications($userId)
    {
        return $this->notificationManager->findAllByUserAndState($userId, 0)->setMaxResults(5)->execute();
    }

    public function readNotification($notification)
    {
        $data  = array();

        foreach($notification->getData() as $key => $value) {
            $data['%'.$key.'%'] = $value;
        }

        return $this->translator->trans($notification->getMessage(), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_extension';
    }
}
