<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleEditType;
use App\Form\ArticleType;
use App\Services\Interface\ArticleServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/article')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class ArticleController extends AbstractController
{
    private ArticleServiceInterface $articleService;
    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    #[Route('/create', name: 'app_admin_article_create')]
    public function create(Request $request, KernelInterface $kernel): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if ($this->articleService->articleStore($request, $form)) {
            return $this->redirectToRoute('all_article');
        }

        return $this->render('admin/article/form.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    #[Route('/{id}/edit', name: 'app_admin_article_edit')]
    public function edit(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $oldArticleImage = $article->getImage();
        $form = $this->createForm(ArticleEditType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//----- Переделать этот метод, не нравится мне он -----//

            if ($request->get('delete')) {
                $article->setImage(null);
                $entityManager->flush();

                return $this->redirectToRoute('app_admin_article_edit', ['id' => $article->getId()]);
            }

            $image = $request->files->get('article_edit')['image'];
            if ($image) {
                $this->articleService->saveImage($image, $article);
            } else {
                $article->setImage($oldArticleImage);
            }

            $entityManager->flush();


            /*if (!$request->get('delete')) {
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
            return $this->redirectToRoute('app_admin_article_edit', ['id' => $article->getId()]);*/
        }

        return $this->render('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{id}/delete', name: 'app_admin_article_delete')]
    public function delete(Article $article): RedirectResponse
    {
        $this->articleService->deleteArticle($article);

        return $this->redirectToRoute('all_article');
    }
}
