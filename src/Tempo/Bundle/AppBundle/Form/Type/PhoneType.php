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
use Symfony\Component\Form\FormInterface;
use Tempo\Bundle\AppBundle\Form\DataTransformer\PhoneTransformer;

class PhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'label' => 'tempo.profile.form.type',
                'required' => true,
                'choices' => array(
                    'cell' => 'tempo.profile.form.cell_phone',
                    'landline' => 'tempo.profile.form.landline_phone',
            )))
            ->add('number', null, array(
                'label' => 'tempo.profile.form.number',
                'required' => true,
            ))
        ;
                
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'phone';
    }
}