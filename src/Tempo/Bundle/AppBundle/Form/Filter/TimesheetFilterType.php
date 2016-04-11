<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimesheetFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', 'text', array(
                    'label' => 'Form',
                    'attr' => array('class' => 'datetimepicker-instance', 'data-dateFormat' => 'mm/dd/yyyy')
            ))
            ->add('to', 'text', array(
                'label' => 'To',
                'attr' => array('class' => 'datetimepicker-instance', 'data-dateFormat' => 'mm/dd/yyyy')
            ))
            ->add('filter', 'submit', array(
                'attr' => array('class' => 'btn btn-primary')
            ))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
