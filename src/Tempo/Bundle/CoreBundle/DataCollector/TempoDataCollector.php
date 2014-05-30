<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tempo\Bundle\CoreBundle\Kernel\Kernel;


class TempoDataCollector extends DataCollector
{
    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data['version'] = Kernel::VERSION;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->data['version'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tempo';
    }
}