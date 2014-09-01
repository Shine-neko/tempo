<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('status', null, array(
            'attr' => array(
                'placeholder' => 'tempo.activity.dashboard.form.status.label'
            )
        )) ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'project_activity';
    }
}