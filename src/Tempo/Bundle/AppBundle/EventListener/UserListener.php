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

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Sylius\Component\Resource\Event\ResourceEvent;
use Tempo\Bundle\AppBundle\Model\UserInterface;

class UserListener
{
    protected $encoderFactory;

    /**
     * @param EncoderFactoryInterface $encoder
     */
    public function __construct(EncoderFactoryInterface $encoder)
    {
        return $this->encoderFactory = $encoder;

    }

    protected function getEncoder(UserInterface $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }

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
        /** @var \Tempo\Bundle\AppBundle\Model\User $user  */
        $user = $event->getAuthenticationToken()->getUser();

        if ($user->getLocale()) {
            $event->getRequest()->setLocale($user->getLocale());
        }
    }

    /**
     * @param ResourceEvent $event
     */
    public function preCreate(ResourceEvent $event)
    {
        $object = $event->getSubject();
        $this->updateUserFields($object);
    }

    /**
     * @param ResourceEvent $event
     */
    public function preUpdate(ResourceEvent $event)
    {
        $object = $event->getSubject();
        $this->updateUserFields($object);
    }

    protected function updatePassword(UserInterface $user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }

        return $user;
    }


    public function updateUserFields(UserInterface $user)
    {
        $this->updatePassword($user);

        return $this;
    }
}
