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
use Symfony\Component\Form\FormViewInterface;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('locale', 'choice', array(
            'choices'   => array(
                'fr'   => 'tempo.profile.form.language.french',
                'en' => 'tempo.profile.form.language.english',
            ),
            'label' => 'tempo.profile.form.locale',
            'required' => true 
        ));
    }

    public function getName()
    {
        return 'setting';
    }
}
