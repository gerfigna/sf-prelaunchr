<?php

namespace Sf\PrelaunchrBundle\Library;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class UserMailer
{
    /**
     *
     * @var \Swift_Mailer
     */
    protected $mailer;
 
    /**
     *
     * @var Twig_Environment
     */
    protected $twig;
    
    /**
     *
     * @var String
     */
    protected $mail_sender;
    
    /**
     *
     * @var UrlGeneratorInterface 
     */
    private $router;
    
    /**
     *
     * @var string
     */
    private $rootUrl;
 
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, $mail_sender, UrlGeneratorInterface $router, $rootUrl)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mail_sender = $mail_sender;
        $this->router = $router;
        $this->rootUrl = $rootUrl;
    }
 
    
   public function sendMessage(\Sf\PrelaunchrBundle\Entity\RegisteredUser $user)
    {

        $template = $this->twig->loadTemplate("SfPrelaunchrBundle:User:mail.html.twig");

        $parameters = array(
            'referral_code' => $user->getReferralCode(),
            'root_url'      => $this->rootUrl
                
        );

        $subject  = trim($template->renderBlock('subject', $parameters));
        $bodyHtml = $template->renderBlock('body_html', $parameters);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setBody($bodyHtml, 'text/html')
            ->setFrom($this->mail_sender)
            ->setTo($user->getEmail())    
        ;
        
        $this->mailer->send($message);
        
    }

    
    
}
