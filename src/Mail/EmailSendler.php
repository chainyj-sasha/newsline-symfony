<?php

namespace App\Mail;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSendler
{
    private $mailer;
    const ADDRESS_FROM = 'lg280683man1@yandex.ru';
    const ADDRESS_TO = 'lg280683man1@yandex.ru';

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail($title, $views): Void
    {
        $email = (new Email())
            ->from(self::ADDRESS_FROM)
            ->to(self::ADDRESS_TO)
            ->subject('Новый просмотр')
            ->text("Статью '$title' просмотрели $views раз");

        $this->mailer->send($email);
    }
}