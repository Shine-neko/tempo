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

use Tempo\Bundle\AppBundle\Model\User;
use Symfony\Component\HttpFoundation\Request;
use Tempo\Bundle\AppBundle\Form\Type\RegisterType;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');
        $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();

        return $this->renderLogin(array(
            'last_username' => $helper->getLastUsername(),
            'error'         => $helper->getLastAuthenticationError(),
            'csrf_token'    => $csrfToken,
            'oauth'         => array('enabled' => $this->container->getParameter('oauth.enabled')),
        ));
    }
    
    public function registerAction(Request $request)
    {
        $signupEnable = $this->get('sylius.templating.helper.settings')->getSettingsParameter('general.signup_enable');
        $access = $this->getManager('access')->getRepository()->findOneBy(array(
            'inviteToken' => $request->get('token', 0)
        ));

        if (!($signupEnable || $access)) {
            throw $this->createNotFoundException();
        }
        
        $token = $request->query->get('token');
        $user = new User();
       

        if (null !== $access) {
            $user->setEmail($access->getInviteEmail());
        }

        $form = $this->createForm(new RegisterType(), $user);
        if ($form->handleRequest($request)->isValid()) {
            $this->get('tempo.domain_manager')->create($user);

            if (null !== $access) {
                $access
                    ->setInviteToken(null)
                    ->setInviteEmail(null)
                    ->setUser($user);
            }

            $this->addFlash('success', 'tempo.security.register.success_register');
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('TempoAppBundle:Security:register.html.twig', array(
            'form' => $form->createView(),
            'token' => $token
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('TempoAppBundle:Security:login.html.twig', $data);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
