<?php

namespace Sf\PrelaunchrBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RequestListener
{
    /**
     *
     * @var \Symfony\Component\Routing\Router 
     */
    private $router;
    
    /**
     *
     */
    private $session;
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $em;


    public function __construct(\Symfony\Component\Routing\Router $router, \Symfony\Component\HttpFoundation\Session\Session $session, \Doctrine\ORM\EntityManager $em)
    {
        $this->router = $router;
        $this->session = $session;
        $this->em = $em;
    }    

    public function onKernelRequest(GetResponseEvent $event)
    {
        
        $request = $event->getRequest();
        $ref = $request->get('ref');
        
        if( $ref  ){
            $referrer = $this->em->getRepository('SfPrelaunchrBundle:RegisteredUser')->findOneBy(array(
                'referral_code' => $ref
            ));
            if($referrer){
                $this->session->set('h_ref', $referrer->getId());
                $event->setResponse(new RedirectResponse($this->router->generate('sf_prelaunchr_new')));
            }
        }
    }
}