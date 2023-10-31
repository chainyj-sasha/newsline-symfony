<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/admin/article/create', name: 'app_admin_article_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($request);
            $article = new Article();
            $article->setTitle($data->getTitle());
            $article->setPreview($data->getPreview());
            $article->setText($data->getText());
            $article->setViews(0);
            $article->setCreatedAt(new \DateTime());

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('all_article');
        }

        return $this->render('admin/article/form.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
