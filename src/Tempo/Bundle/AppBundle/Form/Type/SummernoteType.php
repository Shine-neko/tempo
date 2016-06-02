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
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Tempo\Component\Resource\AssetManagerInterface;
use Tempo\Bundle\AppBundle\Helper\Behavior;

class SummernoteType extends AbstractType
{
    /**
     * @var AssetManagerInterface
     */
    private $resourceManager;

    /**
     * @var Behavior
     */
    private $behaviorManager;

    /**
     * Object constructor
     * @param AssetManagerInterface $resourceManager
     */
    public function __construct(AssetManagerInterface $resourceManager, Behavior $behaviorManager)
    {
        $this->resourceManager = $resourceManager;
        $this->behaviorManager = $behaviorManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr'] = array('class' => 'summernote');
        $this->resourceManager->requireResources(array(
            '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css',
            '/vendor/summernote/dist/summernote.css',
            '/vendor/summernote/dist/summernote-bs3.css',
            '/vendor/summernote/dist/summernote.min.js'
        ));
        $this->behaviorManager->init('summernote');

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'wysiwyg';
    }

    public function getParent()
    {
        return TextareaType::class;
    }
}
