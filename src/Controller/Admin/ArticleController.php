<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\User;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/article/index.html.twig', [
            'articles' => $articleRepository->findBy([], ["createdAt" => "DESC"]),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
            }

            $article->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setPublished(false)
                ->setCover($fichier);
            $this->addFlash(
                'notice',
                'La revue a bien été ajouté!'
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('article_index');
            } else if ($this->isGranted('ROLE_AUTHOR')) {
                return $this->redirectToRoute('article_index', ['id' => $article->getAuthor()->getId()]);
            }
        }

        return $this->render('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                if ($images != null) {
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );

                    $article->setCover($fichier);
                }
            }
            $article->setUpdatedAt(new DateTime());
            $this->addFlash(
                'notice',
                'La revue a bien été modifié!'
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/author/{id}", name="article_index_author", methods={"GET"})
     */
    public function indexAuthor(ArticleRepository $articleRepository, User $user): Response
    {

        return $this->render('admin/article/index_author.html.twig', [
            'articles' => $user->getArticles(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/{id}/change-status", name="article_change_status", methods={"GET"})
     */
    public function changeStatus(Article $article): Response
    {
        $article->setPublished(!$article->getPublished());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('article_index');
    }
}
