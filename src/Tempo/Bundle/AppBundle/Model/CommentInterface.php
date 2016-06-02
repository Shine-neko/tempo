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


interface CommentInterface
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
    public function getAuthor();

    /**
     * @param UserInterface $author
     * @return $this
     */
    public function setAuthor(UserInterface $author);
}
