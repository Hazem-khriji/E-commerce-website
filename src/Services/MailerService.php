<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response; // Make sure to import Response

class MailerService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendEmail(
        $to = "ahmedbenarbia15@gmail.com",
        $content = '<p>See Twig integration for better HTML integration!</p>'
    ): void
    {
        $email = (new Email())
            ->from('furnifurni3@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Order Follow-up!')
            ->text('This is an email concerning your recent order for Furni.')
            ->html($content);

        $this->mailer->send($email);
    }
}