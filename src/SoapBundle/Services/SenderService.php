<?php


namespace SoapBundle\Services;



class SenderService
{
    private $mailer;
    
    
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function sender()
    {

        $message = \Swift_Message::newInstance()
                    ->setSubject('Hello Email')
                    ->setFrom('elouerkhaoui@gmail.com')
                    ->setTo('elouerkhaoui@gmail.com')
                    ->setBody('Body');
        $this->mailer->send($message);
        return 'Hello';
        
    }
}