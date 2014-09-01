<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Array to string transformer.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class ArrayToStringTransformer implements DataTransformerInterface
{
    private $delimiter;

    /**
     * Constructor.
     *
     * @param string $delimiter
     */
    public function __construct($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($array)
    {
        if (!is_array($array)) {
            throw new UnexpectedTypeException($array, 'array');
        }

        return implode($this->delimiter, $array);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string)
    {
        if (empty($string)) {
            return array();
        }

        if (!is_string($string)) {
            throw new UnexpectedTypeException($string, 'string');
        }

        return explode($this->delimiter, $string);
    }
}
