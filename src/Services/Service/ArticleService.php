<?php

namespace App\Services\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Services\Interface\ArticleServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class ArticleService implements ArticleServiceInterface
{
    private ArticleRepository $articleRepository;
    private EntityManagerInterface $entityManager;
    private KernelInterface $kernel;

    public function __construct(
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager,
        KernelInterface $kernel,
    )
    {
        $this->articleRepository = $articleRepository;
        $this->entityManager = $entityManager;
        $this->kernel = $kernel;
    }

    public function getAllArticles(Request $request, PaginatorInterface $paginator): PaginationInterface
    {
        $query = $this->articleRepository->createQueryBuilder('e')
            ->orderBy('e.created_at', 'DESC')
            ->getQuery();

        return $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5,
        );
    }

    public function getOneArticle($id): Article
    {
        return $this->articleRepository->find($id);
    }

    public function articleStore($request, $form): bool
    {
        $flag = false;

            if ($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();

                $image = $request->files->get('article')['image'];                    // получаем катринку из реквеста (article - это form_name)
                if ($image) {
                    $this->saveImage($image, $article);
                }
                $article->setViews(0);
                $article->setCreatedAt(new \DateTime());

                $this->entityManager->persist($article);
                $this->entityManager->flush();

                $flag = true;
            }

        return $flag;
    }
    public function deleteArticle(Article $article): void
    {
        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

    public function saveImage($image, Article $article): void
    {
        $path = $this->kernel->getProjectDir() . '/public/uploads/images';                        // определяем место где будет храниться изображение '/public/uploads/images'
        $imageName = 'uploads/images/' . uniqid() . $image->getClientOriginalName();              // Получаем оригинальное имя картинки
        $image->move($path, $imageName);                                                          // Переносим картинку $imageName в папку $path
        $article->setImage($imageName);
    }

    public function addView(Article $article): void
    {
        $views = $article->getViews() + 1;
        $article->setViews($views);
        $this->entityManager->flush();
    }

}