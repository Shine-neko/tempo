<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Manager;

use Tempo\Bundle\ResourceExtraBundle\Manager\ModelManager;

/**
 *
 * @author Mlanawo Mbechezi <mlanawo.mbechezi@ikimea.com>
 */
class MessageManager extends ModelManager
{

    public function all($room , $limit, $offset, $orderby )
    {
        return $this->getRepository()->findBy(array('room' => $room), $orderby, $limit, $offset);
    }
}
