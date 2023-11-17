<?php

namespace App\Message;

use App\Entity\Article;

class ArticleMessage
{
    private Article $article;
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getArticleTitle(): string
    {
        return $this->article->getTitle();
    }

    public function getArticleViews(): ?int
    {
        return $this->article->getViews();
    }

}