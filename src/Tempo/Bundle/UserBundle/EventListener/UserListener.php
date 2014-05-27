<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent,
    Symfony\Component\HttpKernel\Event\GetResponseEvent,
    Symfony\Component\HttpKernel\HttpKernelInterface;

class UserListener
{
    /**
     * kernel.request event. If a guest user doesn't have an opened session, locale is equal to
     * "undefined" as configured by default in parameters.ini. If so, set as a locale the user's
     * preferred language.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function setLocaleForUnauthenticatedUser(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        if ('undefined' == $request->getLocale()) {
            $request->setLocale($request->getPreferredLanguage());
        }
    }

    /**
     * security.interactive_login event. If a user chose a locale in preferences, it would be set,
     * if not, a locale that was set by setLocaleForUnauthenticatedUser remains.
     *
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     */
    public function setLocaleForAuthenticatedUser(InteractiveLoginEvent $event)
    {
        /** @var \Tempo\Bundle\Bundle\UserBundle\Model\User $user  */
        $user = $event->getAuthenticationToken()->getUser();

        if ($user->getLocale()) {
            $event->getRequest()->setLocale($user->getLocale());
        }
    }
}
