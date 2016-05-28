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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Tempo\Bundle\AppBundle\Form\Type\UserEmailType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'tempo.profile.form.username',
                'required' => true,
            ))
            ->add('firstName', TextType::class, array(
                'label' => 'tempo.profile.form.firstName',
                'required' => true,
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'tempo.profile.form.lastName',
                'required' => true,
            ))
            ->add('emails', CollectionType::class, array(
                'entry_type'   => UserEmailType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'required' => true,
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'tempo.profile.form.password',
                'required' => true,
            ))
            ->add('enabled', CheckboxType::class, array(
                'label' => 'tempo.profile.form.enabled',
                'attr' => array('checked' => 'checked'),
                'required' => true,
            ))
            ->add('skype', TextType::class, array(
                'label' => 'tempo.profile.form.skype',
                'required' => false,
            ))
            ->add('linkedin', TextType::class, array(
                'label' => 'tempo.profile.form.linkedin',
                'required' => false,
            ))
            ->add('viadeo', TextType::class, array(
                'label' => 'tempo.profile.form.viadeo',
                'required' => false,
            ))
            ->add('twitter', TextType::class, array(
                'label' => 'tempo.profile.form.twitter',
                'required' => false,
            ))
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {

                $data = $event->getData();
                $form = $event->getForm();

                if (null !== $data->getPassword()) {
                    $form->add('plainPassword', PasswordType::class, array(
                        'label' => 'tempo.profile.form.password',
                        'required' => false,
                    ));
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tempo\Bundle\AppBundle\Model\User',
        ));
    }

    public function getBlockPrefix()
    {
        return 'tempo_admin_user';
    }
}
