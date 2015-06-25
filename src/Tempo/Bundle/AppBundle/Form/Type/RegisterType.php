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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'required' => true,
                'label' => 'tempo.security.login.username'
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'tempo.security.login.password'),
                'second_options' => array('label' => 'tempo.security.resetting.password_again')
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' => 'tempo.profile.tabs.email'
            ))
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
                $data = $event->getData();
                $form = $event->getForm();
                if ($data->getEmail() !== null) {
                    $form->add('email', 'email', array(
                        'required' => true,
                        'label' => 'tempo.profile.tabs.email',
                        'attr' => array(
                            'readonly' => 'readonly',
                            'disabled' => 'disabled'
                        )
                    ));
                }
            });
    }
    
    
    public function getName()
    {
        return 'register';
    }
}