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

use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Form\Type\ResettingFormType;
use Tempo\Bundle\AppBundle\Manager\UserManager;
use Tempo\Bundle\AppBundle\Model\UserInterface;

class ResettingController extends Controller
{
    public function resetAction(Request $request)
    {
        if ($request->isMethod('POST') && $username = $request->request->get('username')) {
            /** @var UserManager $userManager */
            $userManager = $this->getManager('user');

            try {
                $user = $userManager->findUserByUsernameOrEmail($username);
            } catch(\Exception $exception) {
                $this->addFlash('error', 'tempo.security.resetting.request_no_account');
                return $this->redirectToRoute('user_resetting_reset');
            }

            if ($user->isPasswordRequestNonExpired(60*60*24)) {
                $this->addFlash('normal', 'tempo.security.resetting.request_non_expired');
            }

            if (!$user->getConfirmationToken()) {
                $user->setConfirmationToken($user->generateToken());
                $user->setPasswordRequestedAt(new \DateTime('now', new \DateTimeZone('UTC')));
                $this->get('tempo.domain_manager')->update($user);

                $this->get('tempo.mailer.sender')->sender('TempoAppBundle:Mail:User/reset.html.twig', array(
                    'user' => $user,
                    'emails' => $user->getEmail()
                ));
                $this->addFlash('success', 'tempo.security.resetting.request_success');
            }


            return $this->redirectToRoute('homepage');
        }

        return $this->render('TempoAppBundle:Resetting:reset.html.twig');
    }

    public function resetValidateAction(Request $request, $token)
    {
        /** @var UserManager $userManager */
        $userManager = $this->getManager('user');
        /** @var UserInterface $user */
        $user = $userManager->findUserBy(array('confirmationToken' => $token));

        if (null === $user) {
            throw $this->createNotFoundException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        if ($user->isPasswordRequestNonExpired(5)) {
            $this->addFlash('warning', 'tempo.security.resetting.request_non_expire');
        }

        $form = $this->createForm(new ResettingFormType(), $user);

        if ($form->handleRequest($request)->isValid()) {
            $user->setPasswordRequestedAt(new \DateTime('-24hours', new \DateTimeZone('UTC')));
            $userManager->save($user);
            $this->addFlash('success', 'tempo.security.resetting.request_success_reset');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('TempoAppBundle:Resetting:validate.html.twig', array(
            'form' => $form->createView(),
            'token' => $token
        ));
    }
}
