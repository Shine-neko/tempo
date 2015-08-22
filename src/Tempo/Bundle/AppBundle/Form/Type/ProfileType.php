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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tempo\Bundle\AppBundle\Form\Form\PhoneType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, array(
                'label' => 'tempo.profile.form.email',
                'required' => true
            ))
            ->add('firstName', null, array(
                'label' => 'tempo.profile.form.firstName'
            ))
            ->add('lastName', null, array(
                'label' => 'tempo.profile.form.lastName'
            ))
            ->add('company', null, array(
                'label' => 'tempo.profile.form.company'
            ))
            ->add('jobTitle', null, array(
                'label' => 'tempo.profile.form.job_title'
            ))
            ->add('phones', 'collection', array(
                'type' => 'phone',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'options' => array(
                    'label' => false
            )))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tempo\Bundle\AppBundle\Model\User',
        ));
    }

    public function getName()
    {
        return 'user';
    }
}
