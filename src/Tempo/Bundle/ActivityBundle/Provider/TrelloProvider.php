<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\ActivityBundle\Entity\Activity;

class TrelloProvider  implements ProviderInterface
{
    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {

    }

    /**
     * {inheritedDoc}
     */
    public function getName()
    {
        return 'Trello';
    }
}