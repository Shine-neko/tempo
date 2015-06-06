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
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Tempo\Bundle\AppBundle\Model\Session;
use Tempo\Bundle\AppBundle\Model\UserInterface;
use Tempo\Bundle\AppBundle\Manager\UserManager;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Ikimea\Browser\Browser;

class LastLoginListener implements EventSubscriberInterface
{
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            TempoAppEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin',
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        );
    }

    /**
     * @param UserEvent $event
     */
    public function onImplicitLogin(UserEvent $event)
    {
        $user = $event->getUser();
        $user = $this->createSession($user);
        $this->userManager->save($user);
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if ($user instanceof UserInterface) {
            $user = $this->createSession($user);
            $this->userManager->save($user);
        }
    }

    protected function createSession($user)
    {
        $browser = new Browser();

        $session = (new Session())
            ->setCreatedAt(new \DateTime())
            ->setBrowser(array(
                'brower' => $browser->getBrowser().' '.$browser->getVersion(),
                'plateform' => $browser->getPlatform(),
                'user_agent' => $browser->getUserAgent()
            ))
            ->setUser($user)
        ;
        //@Todo get country

        $user
            ->setLastLogin(new \DateTime())
            ->addSession($session)
        ;

        return $user;
    }
}
