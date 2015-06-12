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

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Tempo\Bundle\AppBundle\Form\Type\ChangePasswordFormType;
use Tempo\Bundle\AppBundle\Form\Type\SettingsType;
use Tempo\Bundle\AppBundle\Form\Type\ProfileType;

class ProfileController extends Controller
{
    /**
     * @return Response
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
     * @return Response
     */
    public function avatarAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->get('tempo.user.profile.form.avatar.factory');
        $handler = $this->get('tempo.user.profile.handler.avatar');

        if (($retval = $handler->process($user)) !== false) {

            switch($retval) {
                case $handler::INTERNAL_ERROR:
                    $avatarProcessError = 'tempo.avatar.failed_internal_error';
                    $this->addFlash('error', $avatarProcessError);
                    break;
                case $handler::WRONG_FORMAT:
                    $avatarProcessError = 'tempo.avatar.failed_valid_file';
                    $this->addFlash('error', $avatarProcessError);
                    break;
                case $handler::AVATAR_DELETED:
                    $avatarProcessError = 'tempo.avatar.success_delete';
                    $this->addFlash('success', $avatarProcessError);
                    break;
                default:
                    $avatarProcessError = 'tempo.avatar.success_edit';
                    $this->addFlash('success', $avatarProcessError);
            }
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

        if ($form->handleRequest($request)->isValid()) {
            $this->get('tempo.domain_manager')->update($user);
            $this->addFlash('success', 'tempo.user.profile_edit_success');
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
        $activities = $this->getManager('activity')
            ->getRepository()->createQueryBuilder('activity')
            ->where('activity.author = :author')
            ->setParameter('author', $profile)
            ->getQuery()->execute();


        return $this->render('TempoAppBundle:Profile:show.html.twig', array(
            'profile' => $profile,
            'organizations' => $organizations,
            'activities' => $activities
        ));
    }

    /**
     * @return Response
     */
    public function settingAction(Request $request)
    {
        $profile = $this->getUser();

        $form = $this->createForm(new SettingsType(), $profile);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('tempo.domain_manager')->update($profile);

            $request->setLocale($profile->getLocale());
            $request->getSession()->set('_locale', $profile->getLocale());

            $this->addFlash('success', 'tempo.user.profile_edit_success');
        }

        return $this->render('TempoAppBundle:Profile:settings.html.twig', array(
            'profile' => $profile,
            'form' => $form->createView()
        ));
    }

    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new ChangePasswordFormType(), $user);

        if ($form->handleRequest($request)->isValid()) {
            $this->get('tempo.domain_manager')->update($user);
            $this->addFlash('success', 'tempo.user.password_change_success');

            return $this->redirectToRoute('user_profile_password');
        }

        return $this->render('TempoAppBundle:Profile:password.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    public function generateTokenAction()
    {
        $user = $this->getUser();
        $random = sha1(uniqid(rand(), true));
        $user->setToken($random);

        $this->get('tempo.domain_manager')->update($user);
        $this->addFlash('success', 'the token was added');

        return $this->redirectToRoute('user_profile_settings');
    }
}