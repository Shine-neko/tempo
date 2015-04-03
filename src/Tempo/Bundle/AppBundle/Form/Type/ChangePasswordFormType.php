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
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('current_password', 'password', array(
                'label' => 'tempo.security.resetting.old_password',
                'mapped' => false,
                'constraints' => new UserPassword()
            ))
            ->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'required' => true,
            'first_options' => array('label' => 'tempo.security.resetting.password'),
            'second_options' => array('label' => 'tempo.security.resetting.password_again'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tempo\Bundle\AppBundle\Model\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_profile_password';
    }
}
