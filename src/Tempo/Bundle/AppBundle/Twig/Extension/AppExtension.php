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

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\Common\Util\Inflector;
use Ikimea\Browser\Browser;
use Tempo\Bundle\AppBundle\Helper\Behavior;

class AppExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var Behavior
     */
    private $behavior;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var  PropertyAccess
     */
    protected $accessor;

    /**
     * @param Behavior $behavior
     */
    public function __construct(Behavior $behavior, array $parameters)
    {
        $this->behavior = $behavior;
        $this->parameters = $parameters;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array(
            'tempo' => array(
                'host' => $this->parameters['appHost']
            ),
            'behavior'  => $this->behavior
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('size', array($this, 'size')),
            new \Twig_SimpleFilter('provider_parse_content', array($this, 'providerContentParse'))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_browser', array($this, 'getBrowser')),
            new \Twig_SimpleFunction('icon', array($this, 'getIcon')),
            new \Twig_SimpleFunction('gravatar', array($this, 'getGravatar')),
            new \Twig_SimpleFunction('get_attribute', array($this, 'getAttribute')),
            new \Twig_SimpleFunction('time_ago', array($this, 'timeAgo'), array(
                'needs_environment' => true,
                'is_safe' => array('html')
            )),
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
     * @param $model
     * @param $property
     * @return bool|mixed
     */
    public function getAttribute($model, $property)
    {
        try {
            return $this->accessor->getValue($model, $property);
        } catch (\Exception $e) {

            $camelize = Inflector::camelize($property);

            if (isset($model[$camelize])) {
                return $model[$camelize];
            }

            if (isset($model[$property])) {
                return $model[$property];
            }
        }

        return false;
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
    public function getGravatar($email, $size = null, $default = null, $rating = null)
    {
        $defaults = array(
            'size'    => 80,
            'rating'  => 'g',
            'default' => null,
        );

        $map = array(
            's' => $size    ?: $defaults['size'],
            'r' => $rating  ?: $defaults['rating'],
            'd' => $default ?: $defaults['default'],
        );

        $hash = md5(strtolower(trim($email)));

        return 'https://secure.gravatar.com/avatar/' . $hash . '?' . http_build_query(array_filter($map));
    }

    public function providerContentParse($content)
    {
        $rules = array(
            '/\[([^\[]+)\]\(([^\)]+)\)/' => '<a href="\2">\1</a>'
        );

        foreach ($rules as $regex => $replacement) {
            $content = preg_replace($regex, $replacement, $content);
        }

        return rtrim($content);
    }

    public function timeAgo(\Twig_Environment $env, \DateTimeInterface $dateTime)
    {
        $date = \twig_localized_date_filter($env, $dateTime, 'medium', 'none', $env->getGlobals()['app']->getRequest()->getLocale());

        return sprintf('<time class="timeago" datetime="%sz">%s</time>',
            explode('+',$dateTime->format('c'))[0],
            $date
        );

    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app.extension';
    }
}
