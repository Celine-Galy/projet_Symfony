<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Article;
use App\Form\CommentType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{

    /**
     * @Route("/new/{id}", name="comment_new", methods={"GET","POST"})
     */
    public function new(Article $article, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new DateTime());
            $comment->setUpdatedAt(new DateTime());
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('main_article_show', ['id' => $article->getId()]);
        }
        return $this->render('comment/new.html.twig', [
            'article' => $article,
            'comment' => $comment,
            'form'    => $form->createView()
        ]);
    }
   
   
}
