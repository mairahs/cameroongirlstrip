<?php
namespace App\Notification;

use Twig\Environment;
use App\Entity\AdContact;

class AdContactNotification
{
    
    public function __construct(\Swift_Mailer $mailer, Environment $render )
    {
        $this->mailer = $mailer;
        $this->render = $render;
    }
    
    public function notify(AdContact $adContact)
    {
        $message = new \Swift_Message('Ton logement '. $adContact->getAd()->getTitle());
        $message->setFrom($adContact->getEmail())
                ->setTo($adContact->getAd()->getAuthor()->getEmail())
                ->setReplyTo($adContact->getEmail())
                ->setBody($this->render->render('email/adcontact.html.twig',[
                    'adContact' => $adContact
                ]), 'text/html');
        $this->mailer->send($message);
    }
}