<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\ElephantIO;

use ElephantIO\Client as Elephant;

class Client
{
    protected $elephantIO;

    /**
     * @param Elephant $elephantIO
     */
    public function __construct(Elephant $elephantIO)
    {
        $this->elephantIO = $elephantIO;

        return $this;
    }

    /**
     * Send to socketio
     * @param string $eventName event name
     * @param mixed  $data      data to send must be serializable
     */
    public function send($eventName, $data)
    {
        $this->elephantIO->init();
        $this->elephantIO->send(Elephant::TYPE_EVENT, null, null, json_encode(array(
            'name' => $eventName,
            'args' => $data
        )));

        $this->elephantIO->close();
    }
}
