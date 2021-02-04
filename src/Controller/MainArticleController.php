<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ArticleLikeRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainArticleController extends AbstractController
{
    /**
     * @Route("/main_article/search", name="search_article", methods={"GET"})
     */
    public function search(Request $request, ArticleRepository $articleRepository): Response
    {
        $terms = $request->get('terms') ?? ''; 
        $articles = $articleRepository->findByTerms($terms);
        return new JsonResponse($articles);

    }

    /**
     * @Route("/main_article/{id}", name="main_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('main_article/show.html.twig', [
            
            'article' => $article,
        ]);
    }

      /**
     * Permet de liker ou unliker un article
     * 
     * @Route("/main_article/{id}/like", name="like_article") 
     * 
     * @param Article $article
     * @param ObjectManager $manager
     * @param ArticleLikeRepository $likeRepo
     * @return Response
     */
    public function like(Article $article, ObjectManager $manager, ArticleLikeRepository $likeRepo) : Response
    {
        $user = $this->getUser();
        if(!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);
        
        if($article->isLikedByUser($user)){
            $like = $likeRepo->findOneBy([
                'article'=> $article,
                'user'=> $user
            ]);
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepo->count([
                    'article' => $article
                ])
            ], 200);
        }
        $like = new ArticleLike();
        $like->setArticle($article)
             ->setUser($user)
             ->setCreatedAt(new DateTime());
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code'=> 200, 
            'message' => 'Like bien ajouté',
            'likes' => $likeRepo->count(['article' => $article])
        ], 200);
    }

}
