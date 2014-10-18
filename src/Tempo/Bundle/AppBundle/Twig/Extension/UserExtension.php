<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\Twig\Extension;

class UserExtension extends \Twig_Extension
{
    private $manager;

    /**
     * @param $manager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
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
        );
    }

    /**
     * @param $userId
     */
    public function getNotifications($userId)
    {
        return $this->manager->findAllByUserAndState($userId, 0)->setMaxResults(5)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_extension';
    }
}
