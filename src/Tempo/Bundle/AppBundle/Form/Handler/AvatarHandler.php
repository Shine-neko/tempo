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
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
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
    protected $imagine;
    protected $path;

    /**
     *
     * @param Request
     */
    public function __construct($request, Form $form, $em, ImagineInterface $imagine)
    {
        $this->request = $request;
        $this->form = $form;
        $this->imagine = $imagine;
        $this->em = $em;
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
    protected function onSuccess(User $user)
    {
        if ($this->request->request->has('delete')) {
            unlink($this->path.$user->getAvatar());
            $user->setAvatar('');
            $user->save();

            return self::AVATAR_DELETED;
        }

        //Upload depuis le disque dur
        if ($this->request->files->has('avatar') && $this->request->files->get('avatar')) {
            $file = $this->request->files->get('avatar');
            $file = $file['avatar'];

            if (!$file->isValid()) {
                return self::INTERNAL_ERROR;
            }


            //Checking the extension and mime type.
            $mimetypes = array('image/jpeg', 'image/png', 'image/gif');
            if (!in_array($file->getMimeType(), $mimetypes)) {
                return self::WRONG_FORMAT;
            }

            //If the user already has a local avatar, it is removed.
            if ($user->hasLocalAvatar()) {
                @unlink($this->getPath(false).$user->getAvatar());
            }

            //Move the temporary file to the avatars.
            $extension = $file->guessExtension();

            $path = array($this->getPath(), $user->getId().'.'.$extension);
            try {
                $file->move($path[0], $path[1]);
            } catch (FileException $e) {
                return self::INTERNAL_ERROR;
            }

            //Resize the avatar if necessary so as not to exceed 100x100..
            $size = getimagesize($path[0].'/'.$path[1]);
            if ($size[0] > 100 || $size[1] > 100)  {
                $this
                    ->imagine
                    ->open($path[0].'/'.$path[1])
                    ->thumbnail(new Box(100, 100))
                    ->save($path[0].'/'.$path[1]);
            }

            //We end by changing the user to tie its new avatar.
            $user->setAvatar($path[1]);

            $this->em->persist($user);
            $this->em->flush();

            return self::AVATAR_CHANGED;
        }

        return false;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath($folder = true)
    {
        return $this->path.($folder ? 'uploads/avatars/' : '' );
    }
}
