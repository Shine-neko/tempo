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

/**
* @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
*/

interface ProjectInterface
{
    /**
     * @return integer $id
     */
    public function getId();

    /**
     * @param string $name
    */
    public function setName($name);

    /**
     * @return string $name
     */
    public function getName();

    /**
     * Put this method in if your slug should be "editable"
     * @param string $slug
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug();

    /**
     * Set created
     *
     * @param \DateTime $created
     */
    public function setCreatedAt(\DateTime $created);

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set updated
     *
     * @param \DateTime $updated
     */
    public function setUpdatedAt(\DateTime $updated);

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * Set last activity
     *
     * @param \DateTime $lastActivity
     */
    public function setLastActivity(\DateTime $lastActivity);

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getLastActivity();

    /**
     * Get organization
     *
     * @return \Tempo\Bundle\AppBundle\Model\Organization
     */
    public function getOrganization();

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set active
     *
     * @param boolean $isActive
     */
    public function setActive($isActive);

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive();

    /**
     * Set beginning
     *
     * @param \DateTime $beginning
     */
    public function setBeginning(\DateTime $beginning);

    /**
     * Get beginning
     *
     * @return \DateTime
     */
    public function getBeginning();

    /**
     * Set ending
     *
     * @param \DateTime $ending
     */
    public function setEnding(\DateTime $ending);

    /**
     * @return \DateTime
     */
    public function getEnding();

    /**
     * Set type
     *
     * @param ProjectTypeInterface $type
     */
    public function setType(ProjectTypeInterface $type = null);

    /**
     * @return integer
     */
    public function getType();

    /**
     * @param integer $avancement
     */
    public function setAdvancement($avancement);

    /**
     * @return integer
     */
    public function getAdvancement();

    /**
     * @param string $code
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param integer $status
     */
    public function setStatus($status);

    /**
     * @return integer
     */
    public function getStatus();

    /**
     * Set budget_estimated
     *
     * @param decimal $budgetEstimated
     */
    public function setBudgetEstimated($budgetEstimated);

    /**
     * @return decimal
     */
    public function getBudgetEstimated();

    /**
     * @param integer $priority
     */
    public function setPriority($priority);

    /**
     * @return integer
     */
    public function getPriority();

    /**
     * @abstract
     * @return mixed
     */
    public function getTeam();

    /**
     * @abstract
     * @param  \Tempo\Bundle\AppBundle\Model\User $membre
     * @return mixed
     */
    public function addUser($user);

    /**
     * Add children
     *
     * @param ProjectInterface $children
     */
    public function addChildren(ProjectInterface $children);

    /**
     * Get children
     *
     * @return array
     */
    public function getChildren();

    /**
     * Set parent
     *
     * @param ProjectInterface $parent
     */
    public function setParent(ProjectInterface $parent = null);

    /**
     * Get parent
     *
     * @param integer $level default -1
     *
     * @return ProjectInterface $parent
     */
    public function getParent($level = -1);

    /**
     * @return array
     */
    public function getParents();
}
