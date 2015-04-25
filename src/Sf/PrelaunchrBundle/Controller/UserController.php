<?php

namespace Sf\PrelaunchrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sf\PrelaunchrBundle\Entity\RegisteredUser;
use Sf\PrelaunchrBundle\Form\Type\RegisteredUserType;


class UserController extends Controller
{
    public function newAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        
        $email = $session->get('h_email');
        if($email && $em->getRepository('SfPrelaunchrBundle:RegisteredUser')->findOneBy(array('email' => $email))){
            return new \Symfony\Component\HttpFoundation\RedirectResponse($this->generateUrl('sf_prelaunchr_refer'));
        }
        
        $user = new RegisteredUser();
        $form = $this->createForm(new RegisteredUserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            if($refCode = $request->getSession()->get('h_ref')){
                $user->setReferrer($em->find('SfPrelaunchrBundle:RegisteredUser', $refCode));
            }
            
            $em->persist($user);
            $em->flush();
            
            $session->set('h_email', $user->getEmail());
            
            $mailer = $this->container->get('sf_prelaunchr.user_mailer');
            $mailer->sendMessage($user);
            
            return $this->redirectToRoute('sf_prelaunchr_refer');
        }
        
        return $this->render('SfPrelaunchrBundle:User:new.html.twig', array(
            'bodyId'=> 'home',
            'form'  => $form->createView()
        ));
    }
    
    
    public function referAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        
        $user = $em->getRepository('SfPrelaunchrBundle:RegisteredUser')->findOneByEmail($session->get('h_email'));
        
        if(!$user){
            return $this->redirectToRoute('sf_prelaunchr_new');
        }
        
        return $this->render('SfPrelaunchrBundle:User:refer.html.twig', array(
            'bodyId'=> 'refer',
            'user'  => $user
        ));
    }
}
