<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Provider;

use Symfony\Component\HttpFoundation\Request;

interface ProviderInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getName();
    public function parse(Request $request);
}