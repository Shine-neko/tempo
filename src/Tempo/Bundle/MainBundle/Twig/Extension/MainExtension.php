<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\MainBundle\Twig\Extension;

use Knp\Bundle\TimeBundle\Templating\Helper\TimeHelper;
use Tempo\Bundle\CoreBundle\Imagine\Cache\CacheManager;

use Ikimea\Browser\Browser;

class MainExtension extends \Twig_Extension
{

    private $container;
    private $helper;

    /**
     * @param $container
     */
    public function __construct($container, TimeHelper $helper)
    {
        $this->container = $container;
        $this->helper = $helper;

    }

    /**
     * {@inheritdoc}
     */
    public function getFilters() {
        return array(
            'size' => new \Twig_Filter_Method($this, 'size'),
            'datetime_diff' => new \Twig_Filter_Method($this, 'dateTimeDiff'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'datetime_diff'  => new \Twig_Function_Method($this, 'dateTimeDiff', array(
                'is_safe' => array('html')
            )),
            'get_browser' => new \Twig_Function_Method($this, 'getBrowser'),
            'truncate' => new \Twig_Function_Method($this, 'truncate'),
            'behavior' => new \Twig_Function_Method($this, 'getBehavior'),
            'icon' => new \Twig_Function_Method($this, 'getIcon'),
            'gravatar'    => new \Twig_Function_Method($this, 'getGravatar'),
        );
    }

    /**
     * @param $string
     * @param $max
     * @param string $replacement
     * @return mixed
     */
    public function truncate($string, $max, $replacement = '')
    {
        if (strlen($string) <= $max) {
            return $string;
        }
        $leave = $max - strlen ($replacement);
        return substr_replace($string, $replacement, $leave);
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

    public function dateTimeDiff($since = null, $to = null)
    {
        if ($since !== null && !$since instanceof \DateTime) {

            $date = new \DateTime();
            $date->setTimestamp((int)$since);
            $since = $date;
        }

        return $this->helper->diff($since, $to);
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
     *  @return \Tempo\Bundle\MainBundle\Helper\Behavior
     */
    public function getBehavior()
    {
        return $this->container->get('tempo.main.behavior');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
       return 'MainExtension';
    }
}