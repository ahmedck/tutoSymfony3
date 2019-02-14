<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_page")
     */
    public function loginAction(Request $request)
    {
       /* if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
           //return $this->redirect($this->generateUrl('backend_dashboard_homepage', array()));
           return $this->redirectToRoute('backend_dashboard_homepage');
        }*/
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('AppBundle:security:login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


}