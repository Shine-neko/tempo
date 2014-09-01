<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Model;

use Tempo\Bundle\UserBundle\Entity\User;

interface ActivityInterface
{
    /**
     * Get id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get target.
     *
     * @return string
     */
    public function getTarget();

    /**
     * Set target.
     *
     * @return string
     */
    public function setTarget($type);

    /**
     * Get target type.
     *
     * @return string
     */
    public function getTargetType();

    /**
     * Set target type.
     *
     * @return string
     */
    public function setTargetType($type);

    /**
     * Get action.
     *
     * @return string
     */
    public function getAction();

    /**
     * Set action.
     *
     * @param string $data
     */
    public function setAction($data);

    /**
     * Get data.
     *
     * @return string
     */
    public function getData();

    /**
     * Set data.
     *
     * @param string $data
     */
    public function setData($data);

    /**
     * get User.
     *
     * @return User $user
     */
    public function getAuthor();

    /**
     * Set User.
     *
     * @param User $user
     */
    public function setAuthor($user);

    /**
     * Creation date.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $created
     */
    public function setCreatedAt(\DateTime $created);
}
