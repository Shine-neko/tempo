<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Form\Handler;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\Form;

/**
 * Manages the form submission change avatar.
 *
 */
class AvatarHandler
{
    const AVATAR_CHANGED = 1;
    const AVATAR_DELETED = 2;
    const INTERNAL_ERROR = 3;
    const WRONG_FORMAT = 4;

    protected $request;
    protected $domainManager;
    protected $path;

    /**
     *
     * @param Request
     */
    public function __construct($request, Form $form, $domainManager)
    {
        $this->request = $request;
        $this->form = $form;
        $this->domainManager = $domainManager;
    }

    /**
     * Performs the form submission.
     *
     * @param $resource Resource it to change
     * @return boolean
     */
    public function process($resource)
    {
        if ($this->request->getMethod() === 'POST') {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                if (isset($this->form->getData()['avatar'])) {
                    return $this->uploading($resource, $this->form->getData()['avatar']);
                }

                if ($this->request->request->has('delete')) {
                    return $this->deleteFile($resource);
                }
            }
        }

        return false;
    }

    /**
     * Action to take when the form is valid.
     *
     * @param $resource
     * @param $file
     * @return bool|int
     */
    protected function uploading($resource, $file)
    {
        if (!$file->isValid()) {
            return self::INTERNAL_ERROR;
        }

        //Checking the extension and mime type.
        $mimetypes = array('image/jpeg', 'image/png', 'image/gif');
        if (!in_array($file->getMimeType(), $mimetypes)) {
            return self::WRONG_FORMAT;
        }

        //If the user already has a local avatar, it is removed.
        if (null !== $resource->getAvatar() && strpos($resource->getAvatar(), 'gravatar') === false) {
            $this->deleteFile($resource);
        }

        //Move the temporary file to the avatars.
        $resourceName = (new \ReflectionClass($resource))->getShortName();
        $filename = strtolower($resourceName).$resource->getId().'.'.$file->guessExtension();

        try {
            $file->move($this->getPath(), $filename);
        } catch (FileException $e) {
            return self::INTERNAL_ERROR;
        }

        //We end by changing the user to tie its new avatar.
        $resource->setAvatar($filename);
        $this->domainManager->update($resource);

        return self::AVATAR_CHANGED;
    }

    protected function deleteFile($resource)
    {
        $file = $this->path. $resource->getAvatar();

        if (is_file($file)) {
            unlink($file);
        }

        $resource->setAvatar('');
        $this->domainManager->update($resource);

        return self::AVATAR_DELETED;
    }

    /**
     *
     * @param type $path
     * @return this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     *
     * @return type
     */
    public function getPath()
    {
        return $this->path. '/avatars/';
    }
}
