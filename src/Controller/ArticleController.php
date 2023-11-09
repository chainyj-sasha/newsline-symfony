<?php

namespace App\Controller;

use App\Services\Interface\ArticleServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private ArticleServiceInterface $articleService;

    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    #[Route('/', name: 'all_article')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $articles = $this->articleService->getAllArticles($request, $paginator);

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/article/{id}', name: 'show_one_article')]
    public function show($id): Response
    {
        $article = $this->articleService->getOneArticle($id);

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
