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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tempo\Bundle\AppBundle\Form\Type\DateTimePickerType;
use Tempo\Bundle\AppBundle\Repository\ProjectTypeRepository;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'tempo.project.form.label.name',
                'required' => true,
            ))
            ->add('description', SummernoteType::class, array(
                'required' => false,
                'label'    => 'tempo.project.form.label.description',
            ))
            ->add('active', null, array(
                'label' => 'tempo.project.form.label.isactive'
            ))
            ->add('beginning', DateTimePickerType::class, array(
                'label' => 'tempo.project.form.label.beginning',
                'required' => false,
            ))
            ->add('ending', DateTimePickerType::class, array(
                'label' => 'tempo.project.form.label.ending',
                'required' => false,
            ))
            ->add('type', null, array(
                'label' => 'tempo.project.form.label.type',
                'class' => 'Tempo\Bundle\AppBundle\Model\ProjectType',
                'query_builder' => function(ProjectTypeRepository $er) {
                    return $er->findAllTypes();
                }
            ))
            ->add('code', TextType::class, array(
                'label' => 'tempo.project.form.label.code',
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'user_id' => null,
            'data_class' => 'Tempo\Bundle\AppBundle\Model\Project',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'project';
    }
}
