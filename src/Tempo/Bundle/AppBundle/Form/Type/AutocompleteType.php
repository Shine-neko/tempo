<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tempo\Bundle\AppBundle\Helper\Behavior;

class AutocompleteType extends AbstractType
{
    protected $behaviorManager;

    /**
     * load script js for autocompletion
     * @param \Tempo\Bundle\AppBundle\Helper\Behavior $behaviorManager
     */
    public function __construct(Behavior $behaviorManager)
    {
       $this->behaviorManager = $behaviorManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $router = $this->behaviorManager->getRouter();

        $this->behaviorManager->init('autocomplete', array( 'id' => $options['behavior']['name'],'callback' => $router->generate($options['behavior']['callback'])));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'behavior' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'autocomplete';
    }
}
