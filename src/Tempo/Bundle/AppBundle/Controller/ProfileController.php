<?php

/*
* This file is part of the Tempo-project package http://tempo-project.org/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Tempo\Bundle\AppBundle\Form\Type\ChangePasswordFormType;
use Tempo\Bundle\AppBundle\Form\Type\SettingsType;
use Tempo\Bundle\AppBundle\Form\Type\ProfileType;

class ProfileController extends Controller
{
    /**
     * @param $slug
     * @return mixed
     */
    public function editAction()
    {
        $form = $this->createForm(new ProfileType(), $this->getUser());

        return $this->render('TempoAppBundle:Profile:edit.html.twig', array(
            'user' => $this->getUser(),
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     * @todo : Urgent refactor
     */
    public function pictureAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->get('tempo.user.profile.form.avatar.factory');
        $handler = $this->get('tempo.user.profile.handler.avatar');

        if (($retval = $handler->process($user)) !== false) {

            switch($retval) {
                case $handler::INTERNAL_ERROR:
                    $avatarProcessError = 'avatar.failed_internal_error';
                    break;
                case $handler::WRONG_FORMAT:
                    $avatarProcessError = 'avatar.failed_valid_file';
                    break;
                case $handler::AVATAR_DELETED:
                    $avatarProcessError = 'avatar.success_delete';
                    break;
                default:
                    $avatarProcessError = 'avatar.success_edit';
            }

            $this->addFlash('error', $avatarProcessError, 'TempoUser');
        }

        return $this->render('TempoAppBundle:Profile:avatar.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function updateAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new ProfileType(), $user);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
           $em = $this->getDoctrine()->getManager();
           $em->persist($user);
           $em->flush();
        }

        return $this->render( 'TempoAppBundle:Profile:edit.html.twig',  array(
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ));

    }

    /**
     * @param $slug
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($slug)
    {
        $profile = $this->getManager('user')->getRepository()->findOneBy(array('slug' => $slug));

        if(!$profile) {
            throw $this->createNotFoundException('User not found.');
        }

        $organizations = $this->getManager('organization')->findAllByUser($profile->getId());

        return $this->render('TempoAppBundle:Profile:show.html.twig', array(
            'profile' => $profile,
            'organizations' => $organizations
        ));
    }

    /**
     * @return Response
     */
    public function settingAction()
    {
        $profile = $this->getUser();

        $form = $this->createForm(new SettingsType());

        return $this->render('TempoAppBundle:Profile:settings.html.twig', array(
            'profile' => $profile,
            'form' => $form->createView()
        ));
    }

    public function changePasswordAction(Request $request)
    {
        $profile = $this->getUser();

        $form = $this->createForm(new ChangePasswordFormType(), $profile);

        if ($form->handleRequest($request)->isValid()) {
            $this->getManager('user')->save($profile);

            $this->addFlash('success', 'tempo.user.password_change_success');

            $this->redirectRoute('user_profile_password');
        }

        return $this->render('TempoAppBundle:Profile:password.html.twig', array(
            'profile' => $profile,
            'form' => $form->createView()
        ));
    }

    public function generateTokenAction()
    {
        $user = $this->getUser();

        $random = sha1(uniqid(rand(), true));

        $user->setToken($random);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'the token was added');

        return $this->redirectRoute('user_profile_edit');
    }
}
