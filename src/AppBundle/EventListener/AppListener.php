<?php
namespace  AppBundle\EventListener ;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class AppListener
{

    private $container;



    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // Get Local from session , if that not exit retreieve it from the default local
        $local = $request->getSession()->get("Locale" , $this->container->getParameter('locale') );
        $this->container->get("translator")->setLocale($local);
        $request->setLocale($local);
    }



}
