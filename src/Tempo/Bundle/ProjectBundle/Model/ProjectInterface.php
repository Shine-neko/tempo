<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\ProjectBundle\Model;

/**
* @author Mbechezi Mlanawo <mlanawo.mbechezi@ikimea.com>
*/

interface ProjectInterface
{

    /**
     * Put this method in if your slug should be "editable"
     * @param string $slug
     */
    public function setSlug($slug);

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
    public function setCreated($created);

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Set updated
     *
     * @param \DateTime $updated
     */
    public function setUpdated($updated);

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated();

    /**
     * Get client
     *
     * @return Tempo\Bundle\ProjectBundle\Entity\Client
     */
    public function getClient();

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
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive);

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Set beginning
     *
     * @param \DateTime $beginning
     */
    public function setBeginning($beginning);

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
    public function setEnding($ending);

    /**
     * @return \DateTime
     */
    public function getEnding();

    /**
     * Set type
     *
     * @param integer $type
     */
    public function setType($type);

    /**
     * @return integer
     */
    public function getType();

    /**
     * @param integer $avancement
     */
    public function setAvancement($avancement);

    /**
     * @return integer
     */
    public function getAvancement();

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
    public function getEquipe();

    /**
     * @abstract
     * @param  \Tempo\Bundle\UserBundle\Entity\User $membre
     * @return mixed
     */
    public function addEquipe( $user);

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
