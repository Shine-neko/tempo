<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Util;

use Doctrine\Common\Util\ClassUtils as BaseClassUtils;

class ClassUtils
{
    public static function getShortName($class)
    {
        $resourceName = BaseClassUtils::newReflectionClass($class);

        return strtolower($resourceName->getShortName());
    }
}
