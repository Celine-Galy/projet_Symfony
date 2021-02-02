<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/main_article")
 */
class MainArticleController extends AbstractController
{
    /**
     * @Route("/search", name="search_article", methods={"GET"})
     */
    public function search(Request $request, ArticleRepository $articleRepository): Response
    {
        $terms = $request->get('terms') ?? ''; 
        $articles = $articleRepository->findByTerms($terms);
        return new JsonResponse($articles);

    }

    /**
     * @Route("/{id}", name="main_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('main_article/show.html.twig', [
            
            'article' => $article,
        ]);
    }
}
