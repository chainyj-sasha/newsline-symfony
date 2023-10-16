<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(): Response
    {
        $a = 1;
        $b = 2;
        echo $a + $b;
        return $this->render('posts/index.html.twig', [
            'controller_name' => 'PostsController',
        ]);
    }
}
