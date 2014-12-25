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
use Tempo\Bundle\AppBundle\Repository\ProjectTypeRepository;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'tempo.project.form.label.name',
                'required' => true,
            ))
            ->add('description', 'ckeditor', array(
                'required' => false,
                'label'    => 'tempo.project.form.label.isactive',
                'config_name' => 'default',
            ))
            ->add('active', null, array(
                'label' => 'tempo.project.form.label.isactive'
            ))
            ->add('beginning', 'datetimepicker', array(
                'label' => 'tempo.project.form.label.beginning',
                'required' => false,
            ))
            ->add('ending', 'datetimepicker', array(
                'label' => 'tempo.project.form.label.ending',
                'required' => false,
            ))
            ->add('type', null, array(
                'label' => 'tempo.project.form.label.type',
                'class' => 'TempoAppBundle:ProjectType',
                'query_builder' => function(ProjectTypeRepository $er) {
                    return $er->findAllTypes();
                }
            ))
            ->add('advancement', null, array(
                'label' => 'tempo.project.form.label.advancement',
                'attr' => array(
                    'disabled' => 'disabled',
                    'style' => 'display: none'
                )
            ))
            ->add('code', null, array(
                'label' => 'tempo.project.form.label.code',
                'required' => false,
            ))
            ->add('budget_estimated', null, array(
                'label' => 'tempo.project.form.label.estimated',
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'user_id' => null,
            'data_class' => 'Tempo\Bundle\AppBundle\Model\Project',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'project';
    }
}
