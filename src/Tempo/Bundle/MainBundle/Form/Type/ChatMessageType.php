<?php

namespace Tempo\Bundle\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for chatMessages in the API
 */
class ChatMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Tempo\Bundle\MainBundle\Entity\ChatMessage',
                'csrf_protection' => false
            )
        );
    }

    public function getName()
    {
        return '';
    }
}
