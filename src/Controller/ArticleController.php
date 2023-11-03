<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/', name: 'all_article')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $query = $this->articleRepository->findAll();

        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10,
        );

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
