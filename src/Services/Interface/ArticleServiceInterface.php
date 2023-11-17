<?php

namespace App\Services\Interface;

use App\Entity\Article;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

interface ArticleServiceInterface
{
    public function getAllArticles(Request $request, PaginatorInterface $paginator): PaginationInterface;

    public function getOneArticle($id): Article;

    public function articleStore(Request $request, $form);

    public function deleteArticle(Article $article): void;

    public function saveImage($image, Article $article): void;

    public function addView(Article $article): void;

}