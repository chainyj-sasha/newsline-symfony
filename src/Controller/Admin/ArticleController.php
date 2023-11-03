<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleEditType;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public function __construct()
    {}

    #[Route('/admin/article/create', name: 'app_admin_article_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            //----- сделать отдельный метод сервита для работы с изображением -----//

            $image = $request->files->get('article')['image'];                                    // получаем катринку из реквеста (article - это form_name)
            $path = $this->getParameter('kernel.project_dir') . '/public/uploads/images';      // определяем место где будет храниться изображение '/public/uploads/images'
            $imageName = 'uploads/images/' . uniqid() . $image->getClientOriginalName();                                // Получаем оригинальное имя картинки
            $image->move($path, $imageName);                                                        // Переносим картинку $imageName в папку $path

            //---------//

            $article->setImage($imageName);
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
    #[Route('/admin/article/{id}/edit', name: 'app_admin_article_edit')]
    public function edit(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $oldArticleImage = $article->getImage();
        $form = $this->createForm(ArticleEditType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//----- Переделать этот метод, не нравится мне он -----//

            if (!$request->get('delete')) {
                $image = $request->files->get('article_edit')['image'];

                if ($image) {
                    $path = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
                    $imageName = 'uploads/images/' . uniqid() . $image->getClientOriginalName();
                    $image->move($path, $imageName);
                    $article->setImage($imageName);
                } else {
                    $article->setImage($oldArticleImage);
                }

                $entityManager->flush();
                return $this->redirectToRoute('app_admin_article_edit', ['id' => $article->getId()]);
            }

            $article->setImage(null);

            $entityManager->flush();
            return $this->redirectToRoute('app_admin_article_edit', ['id' => $article->getId()]);
        }

        return $this->render('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/article/{id}/delete', name: 'app_admin_article_delete')]
    public function delete(Article $article, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('all_article');
    }
}
