<?php

namespace App\MessageHandler;

use App\Mail\EmailSendler;
use App\Message\ArticleMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ArticleHandler
{
    private EmailSendler $sendler;

    public function __construct(EmailSendler $sendler)
    {
        $this->sendler = $sendler;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(ArticleMessage $message): void
    {
        $title = $message->getArticleTitle();
        $views = $message->getArticleViews();
        $this->sendler->sendEmail($title, $views);
    }
}