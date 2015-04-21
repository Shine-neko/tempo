<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Form\Type\Admin;

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
            ->add('username', 'text', array(
                'label' => 'tempo.profile.form.username',
                'required'  => true,
            ))
            ->add('firstName', 'text', array(
                'label' => 'tempo.profile.form.firstName',
                'required'  => true,
            ))
            ->add('lastName', 'text', array(
                'label' => 'tempo.profile.form.lastName',
                'required'  => true,
            ))
            ->add('email', 'email', array(
                'label' => 'tempo.profile.form.email',
                'required'  => true,
            ))
            ->add('plainPassword', 'password', array(
                'label' => 'tempo.profile.form.password',
                'required'  => true,
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'tempo.profile.form.enabled',
                'attr'  => array('checked'   => 'checked'),
                'required'  => true,
            ))
            ->add('skype', null, array(
                'label' => 'tempo.profile.form.skype',
                'required'  => false,
            ))
            ->add('linkedin', null, array(
                'label' => 'tempo.profile.form.linkedin',
                'required'  => false,
            ))
            ->add('viadeo', null, array(
                'label' => 'tempo.profile.form.viadeo',
                'required'  => false,
            ))
            ->add('twitter', null, array(
                'label' => 'tempo.profile.form.twitter',
                'required'  => false,
            ))
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
        return 'tempo_admin_user';
    }
}
