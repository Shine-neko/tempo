<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Component\Resource\Twig;

use Ikimea\Browser\Browser;


class ResourceExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_browser', array($this, 'getBrowser')),
            new \Twig_SimpleFunction('gravatar', array($this, 'getGravatar')),
        );
    }

    /**
     * @return string
     */
    public function getBrowser()
    {
        $browser = new Browser() ;
        $navigateurFinal = explode('.', $browser->getVersion() );

        return strtolower($browser->getBrowser(). ' ' .
            $browser->getBrowser().$navigateurFinal[0]). ' '.
        $browser->getPlatform();
    }

    // get gravatar image
    public function getGravatar($email, $size = null, $default = null, $rating = null, $secure = null)
    {
        $defaults = array(
            'size'    => 80,
            'rating'  => 'g',
            'default' => null,
            'secure'  => false,
        );

        $map = array(
            's' => $size    ?: $defaults['size'],
            'r' => $rating  ?: $defaults['rating'],
            'd' => $default ?: $defaults['default'],
        );

        $hash = md5(strtolower(trim($email)));

        if (null === $secure) {
            $secure = $defaults['secure'];
        }

        return ($secure ? 'https://secure' : 'http://www') . '.gravatar.com/avatar/' . $hash . '?' . http_build_query(array_filter($map));
    }

    public function getName()
    {
       return 'resource';
    }
}
