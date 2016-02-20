<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface CommentInterface extends ResourceInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param $body
     * @return $this
     */
    public function setBody($body);

    /**
     * @return User
     */
    public function getSender();

    /**
     * @param UserInterface $sender
     * @return $this
     */
    public function setSender(UserInterface $sender);
}
