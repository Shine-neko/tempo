<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\AppBundle\Twig\Extension;

use Ikimea\Browser\Browser;
use Tempo\Bundle\AppBundle\Helper\Behavior;

class AppExtension extends \Twig_Extension
{
    private $behavior;

    /**
     * @param Behavior $behavior
     */
    public function __construct(Behavior $behavior)
    {
        $this->behavior = $behavior;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array(
            'behavior'  => $this->behavior
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'size' => new \Twig_Filter_Method($this, 'size'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'get_browser' => new \Twig_Function_Method($this, 'getBrowser'),
            'icon' => new \Twig_Function_Method($this, 'getIcon'),
            'gravatar'    => new \Twig_Function_Method($this, 'getGravatar'),
        );
    }

    /**
     * calcule size file
     * @param $size
     * @return string
     */
    public function size($size)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
        return round($size, 2).$units[$i];
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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
       return 'main_extension';
    }
}
