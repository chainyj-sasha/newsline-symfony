<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/articles', name: 'all_article')]
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/article/{id}', name: 'show_one_article')]
    public function show($id)
    {
        $article = $this->articleRepository->find($id);

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
