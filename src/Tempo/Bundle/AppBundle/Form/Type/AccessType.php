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

class AccessType extends AbstractType
{
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'autocomplete', array(
                'behavior' => array('name' => 'access_username', 'callback' => 'api_user_autocomplete' ),
                'label' => 'tempo.team.username'
            ))
            ->add('role', 'choice', array(
                'choices' => array(
                    AccessInterface::TYPE_OWNER,
                    AccessInterface::TYPE_COLLABORATOR,
                    AccessInterface::TYPE_PARTNER
                )
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $data = $event->getData();
            $form = $event->getForm();

            if ($this->resource instanceof ProjectInterface) {
                $form->add('cost', 'text', array(
                    'required' => true,
                    'label' => 'tempo.team.cost'
                ));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'access';
    }
}
