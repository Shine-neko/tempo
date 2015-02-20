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
use Tempo\Component\Resource\AssetManagerInterface;

class SummernoteType extends AbstractType
{
    /**
     * The security context
     * @var AssetManagerInterface
     */
    private $resourceManager;

    /**
     * Object constructor
     * @param AssetManagerInterface $resourceManager
     */
    public function __construct(AssetManagerInterface $resourceManager)
    {
        $this->resourceManager = $resourceManager;
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
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'wysiwyg';
    }

    public function getParent()
    {
        return 'textarea';
    }
}