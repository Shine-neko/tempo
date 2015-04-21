<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Controller\Controller;

class UserController extends Controller
{
    /*
     * @param Request $request
     * @param null $username
     * @return Response
     */
    public function autocompleteAction(Request $request, $username = null)
    {
        $username = $request->query->get('term', $username);
        $users = array();

        $list_user = ($username == 'all'  ) ?
            $this->get('tempo.repository.user')->findAll() :
            $this->get('tempo.repository.user')->autocomplete($username);

        foreach ($list_user as $name) {
            $users[] = $name['username'];
        }

        return $this->handleView($this->view($users));
    }

    /**
     * @return Response
     */
    public function currentAction()
    {
        $view = $this->view($this->getUser(), 200);
        return $this->handleView($view);
    }
}
