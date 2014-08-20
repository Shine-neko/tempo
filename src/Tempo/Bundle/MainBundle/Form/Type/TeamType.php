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

use Tempo\Bundle\MainBundle\Model\TeamInterface;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'autocomplete', array(
            'behavior' => array('name' => 'team_username', 'callback' => 'user_api_autocomplete' )
            ))
            ->add('role', 'choice', array(
                'choices' => array(
                    TeamInterface::TYPE_ADMIN => 'admin',
                    TeamInterface::TYPE_MODERATOR => 'moderator',
                    TeamInterface::TYPE_USER => 'user'
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'team';
    }
}
