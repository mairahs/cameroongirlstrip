<?php
namespace App\Notification;

use Twig\Environment;
use App\Entity\TripContact;

class TripContactNotification
{
    
    public function __construct(\Swift_Mailer $mailer, Environment $render )
    {
        $this->mailer = $mailer;
        $this->render = $render;
    }
    
    public function notify(TripContact $tripContact)
    {
        $message = new \Swift_Message('Ton voyage '. $tripContact->getTrip()->getDeparture().' - '. $tripContact->getTrip()->getArrival());
        $message->setFrom($tripContact->getEmail())
                ->setTo($tripContact->getTrip()->getTraveller()->getEmail())
                ->setReplyTo($tripContact->getEmail())
                ->setBody($this->render->render('email/tripcontact.html.twig',[
                    'tripContact' => $tripContact
                ]), 'text/html');
        $this->mailer->send($message);
    }
}