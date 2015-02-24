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
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use Tempo\Bundle\AppBundle\Model\AccessInterface;
use Tempo\Bundle\AppBundle\Model\ProjectInterface;

class TeamType extends AbstractType
{
    protected $parentData;

    public function __construct($parentData)
    {
        $this->parentData = $parentData;
    }

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
                    AccessInterface::TYPE_OWNER,
                    AccessInterface::TYPE_COLLABORATOR => 'moderator',
                    AccessInterface::TYPE_PARTNER => 'user'
                )
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $data = $event->getData();
            $form = $event->getForm();

            if ($this->parentData instanceof ProjectInterface) {
                $form->add('cost', 'text');
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'team';
    }
}
