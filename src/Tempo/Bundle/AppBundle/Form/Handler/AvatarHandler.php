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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\Form;
use Tempo\Bundle\AppBundle\Model\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @param  User $user Use it to change
     * @return boolean
     */
    public function process(User $user)
    {
        if ($this->request->getMethod() === 'POST') {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                return $this->onSuccess($user);
            }
        }

        return false;
    }

    /**
     * Action to take when the form is valid.
     *
     * @param User $user
     */
    protected function onSuccess($resource)
    {
        if ($this->request->request->has('delete')) {
            unlink($this->path.$user->getAvatar());
            $user->setAvatar('');
            $this->domainManager->update($user);        
            
            return self::AVATAR_DELETED;
        }

        //Upload depuis le disque dur
        if ($this->request->files->has('avatar') && $this->request->files->get('avatar')) {
            $file = $this->request->files->get('avatar')['avatar'];
            
            if (!$file->isValid()) {
                return self::INTERNAL_ERROR;
            }

            //Checking the extension and mime type.
            $mimetypes = array('image/jpeg', 'image/png', 'image/gif');
            if (!in_array($file->getMimeType(), $mimetypes)) {
                return self::WRONG_FORMAT;
            }

            //If the user already has a local avatar, it is removed.
            if (null !== $user->getAvatar() && strpos($user->getAvatar(), 'gravatar') === false) {
                @unlink($this->getPath().$user->getAvatar());
            }

            //Move the temporary file to the avatars.
            $resourceName = (new \ReflectionClass($resource))->getShortName();
            $filename = strtolower($resourceName).$user->getId().'.'.$file->guessExtension()
 
            try {
                $file->move($this->getPath(), $filename);
            } catch (FileException $e) {
                return self::INTERNAL_ERROR;
            }

            //We end by changing the user to tie its new avatar.
            $user->setAvatar($filename);
            $this->domainManager->update($user);        

            return self::AVATAR_CHANGED;
        }

        return false;
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
