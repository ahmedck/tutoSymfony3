<?php

namespace Backend\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('BackendDashboardBundle:Default:index.html.twig' ,   array( ));
    }
}
