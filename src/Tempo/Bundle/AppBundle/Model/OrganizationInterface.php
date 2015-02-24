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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
 */
interface OrganizationInterface
{
    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId();

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @return $enabled
     */
    public function isEnabled();

    /**
     * @return $enabled
     */
    public function isDeletedAt();

    /**
     *  @return $contact
     */
    public function getContact();

    /**
     * @return $users
     */
    public function getUsers();

    /**
     * Get projects
     *
     * @return \Tempo\Bundle\AppBundle\Model\Project
     */
    public function getProjects();

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug);

    /**
     * Set created
     *
     * @param \DateTime $created
     */
    public function setCreatedAt(\DateTime $updated);

    /**
     * Set updated
     *
     * @param \DateTime $updated
     */
    public function setUpdatedAt(\DateTime $updated);

    /**
     * @param $enabled
     */
    public function setEnabled($enabled);

    /**
     * @param $enabled
     */
    public function setDeleteAt($enabled);

    /**
     *  set contact
     * @param string $contact
     */
    public function setContact($contact);

    /**
     * Set users
     *
     * @param ArrayCollection $users
     */
    public function setUsers($users);

    /**
     * Set user
     *
     * @param $user
     */
    public function addUser($user);

    /**
     * Add projects
     *
     * @param \Tempo\Bundle\AppBundle\Model\Project $project
     */
    public function addProject($project);

    /**
     * Set projects
     *
     * @param ArrayCollection $projects
     */
    public function setProjects($projects);

    /**
     * @abstract
     * @return ArrayCollection
     */
    public function getMembers();

    /**
     * @abstract
     * @param $membre
     * @return mixed
     */
    public function addTeam($user, array $acl = array());
}
