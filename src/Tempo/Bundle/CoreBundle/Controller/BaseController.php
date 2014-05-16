<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BaseController extends FOSRestController
{
    protected static $_flashTypes = array('normal', 'success', 'warning', 'danger');

    public function addFlash($type, $message, $domaine = null)
    {
        if (!in_array($type, self::$_flashTypes)) {
            throw new \Exception(sprintf(
                'Available values: %s',
                implode(', ', self::$_flashTypes)
            ));
        }

        $this->get('request_stack')
            ->getCurrentRequest()
                ->getSession()->getFlashBag()->add(
                    $type,
                    $this->get('translator')->trans($message, array(), $domaine)
                );
    }

    /**
     * @param $key
     * @param $token
     * @return bool
     * @throws AccessDeniedException
     */
    public function tokenIsValid($key, $token)
    {
        //check token
        if (false === $this->get('form.csrf_provider')->isCsrfTokenValid($key, $token)) {
            throw new AccessDeniedException('Invalid token.');
        }

        return true;
    }

    /**
     * @param $message
     * @param array $parameter
     * @param null $domaine
     * @return string
     */
    public function getTranslation($message, $parameter = array(), $domaine = null)
    {
        return $this->get('translator')->trans($message, $parameter, $domaine);
    }

    /**
     * @param $name
     * @return \Tempo\Bundle\CoreBundle\Manager\BaseManager
     */
    public function getManager($name)
    {
        return $this->get('tempo.manager.'. $name);
    }

    /**
     * @return \Problematic\AclManagerBundle\Domain\AclManager
     */
    protected function getAclManager()
    {
        return $this->get('problematic.acl_manager');
    }
}