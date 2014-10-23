<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Form\Type\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array(
                'label' => 'tempo.profile.form.firstName'
            ))
            ->add('lastName', 'text', array(
                'label' => 'tempo.profile.form.lastName'
            ))
            ->add('email', 'email', array(
                'label' => 'tempo.profile.form.email'
            ))
            ->add('plainPassword', 'password', array(
                'label' => 'tempo.profile.form.password'
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'tempo.profile.form.enabled'
            ))
            ->add('skype', null, array(
                'label' => 'tempo.profile.form.skype'
            ))
            ->add('linkedin', null, array(
                'label' => 'tempo.profile.form.linkedin'
            ))
            ->add('viadeo', null, array(
                'label' => 'tempo.profile.form.viadeo'
            ))
            ->add('twitter', null, array(
                'label' => 'tempo.profile.form.twitter'
            ))
            ->add('groups')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tempo\Bundle\AppBundle\Model\User'
        ));
    }

    public function getName()
    {
        return 'tempo_backend_user';
    }
}
