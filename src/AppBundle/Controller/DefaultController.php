<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {
        $error = null;
        $msgSent = false;

        if ($request->isMethod("POST")) {
            $fullname = $request->get("fullname");
            $email = $request->get("email");
            $subject = $request->get("subject");
            $message = $request->get("message");


            try {
                if (trim($fullname) == "") {
                    $error = "Nom obligatoire";
                } elseif (trim($email) == "") {
                    $error = "Adresse Email obligatoire";
                } elseif (trim($subject) == "") {
                    $error = "Sujet obligatoire";
                } elseif (trim($message) == "") {
                    $error = "Message obligatoire";
                } else {

                    $message = (new \Swift_Message())
                        ->setFrom('admin@oxygene.com')
                        ->setTo($email)
                        ->setSubject($subject)
                        ->setBody(
                            $message,
                            'text/html'
                        );

                    $failedRecipients = null;
                    $msgSent = $mailer->send($message, $failedRecipients);

                    if(count($failedRecipients)>0){
                        $error = "Erreur d'envoi" ;
                    }

                }

            } catch (\Exception $e) {
                $error = $e->getMessage();
            }


        }

        return $this->render('AppBundle:Default:contact.html.twig', array('error' => $error , 'msgSent' => $msgSent));
    }




    /**
     * @Route("/changeLanguage/{lang}", name="change_language" , methods={"POST","GET"})
     */
    public function changeLanguageAction(Request $request )
    {
        // Get Local from session , if that not exist retreieve it from the default local
         $local = $request->getSession()->get("Locale" , $this->container->getParameter('locale'));
         // get local from request parameter
         if($request->get('lang')){
             $local = $request->get('lang');
             // If local not supported use the default local
             if( !in_array($local , array('fr','en', 'ar')) ){
                 $local = $this->container->getParameter('locale');
             }
         }
         $request->getSession()->set("Locale" , $request->get('lang'));
         return new Response();
     }






}
