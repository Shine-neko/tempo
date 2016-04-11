<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Mailer;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tempo\Bundle\AppBundle\TempoAppEvents;
use Tempo\Bundle\AppBundle\Event\MailerEvent;

class Sender
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var
     */
    protected $mailer;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param \Twig_Environment        $twig
     * @param $mailer
     * @param array $parameters
     */
    public function __construct(EventDispatcherInterface $dispatcher, \Twig_Environment $twig, $mailer, $parameters)
    {
        $this->dispatcher = $dispatcher;
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function sender($view, array $data = array())
    {
        /** @var \Twig_Template $template */
        $template = $this->twig->loadTemplate($view);
        $dataContext = array_merge($this->twig->getGlobals(), $data);

        $subject = $template->renderBlock('subject', $dataContext);
        $body = $template->renderBlock('content', $dataContext);

        $this->dispatcher->dispatch(TempoAppEvents::EMAIL_PRE_RENDER, new MailerEvent($subject, $body));

        $content = $this->twig->render($view, $data);

        $this->dispatcher->dispatch(TempoAppEvents::EMAIL_RENDER, new MailerEvent($subject, $body));

        if (!is_array($data['emails'])) {
            $data['emails'] = array($data['emails']);
        }

        $message = (new \Swift_Message())
            ->setSubject('[Tempo]'.$subject)
            ->setFrom($this->parameters['from'])
            ->setTo($data['emails'])
            ->setBody($content, 'text/html');

        $this->mailer->send($message);
    }
}
