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
use Tempo\Bundle\AppBundle\Form\Type\EmailType;
use Tempo\Bundle\AppBundle\Model\UserEmail;


class UserEmailController extends Controller
{
    public function addAction(Request $request)
    {
        $user = $this->getUser();
        $userEmail = (new UserEmail());
        $form = $this->createForm(new EmailType(), $userEmail);
        
        if ($form->handleRequest($request)->isValid()) {
            $userEmail->setUser($user);
            $this->get('tempo.domain_manager')->update($user);
            $this->addFlash('success', 'tempo.profile.edit_success');
        }
        
        return $this->render('TempoAppBundle:Profile:email.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }
    
    public function changeStatusAction(UserEmail $userEmail, $status)
    {
        $user = $this->getUser();
        
        if(!$user->getEmails()->contains($userEmail)) {
            return $this->createAccessDeniedException();
        }
        
        if($status == 'public') {
            $userEmail->setStatus($userEmail::STATUS_PUBLIC);
        } elseif ($status == 'private') {
            $userEmail->setStatus($userEmail::STATUS_PRIVATE);
        }
        
        return $this->redirectToRoute('user_email_edit');
    }
    
    public function deleteAction(UserEmail $userEmail)
    {
        $user = $this->getUser();
        
        if(!$user->getEmails()->contains($userEmail)) {
            return $this->createAccessDeniedException();
        }
        if($userEmail->getMain()) {
            $this->addFlash('error', 'tempo.profile.delete_main_adress');
        } else {
            $this->get('tempo.domain_manager')->delete($userEmail);
            $this->addFlash('success', 'tempo.profile.edit_success');
        }
        return $this->redirectToRoute('user_email_edit');
    }
    
    public function setAsMainAction(UserEmail $userEmail)
    {
        $user = $this->getUser();
        
        if(!$user->getEmails()->contains($userEmail)) {
            return $this->createAccessDeniedException();
        }
        
        $currentMain = $this->get('tempo.repository.user_email')->findOneBy(array(
            'main' => true,
            'user' => $user
        ))->setMain(false);
        $userEmail->setMain(true);
        
        $this->get('tempo.domain_manager')->update($userEmail);
        $this->get('tempo.domain_manager')->update($currentMain);
        $this->addFlash('success', 'tempo.profile.edit_success');
        
        return $this->redirectToRoute('user_email_edit');
    }

}