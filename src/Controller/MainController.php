<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'articles' => $articleRepository->findBy(['published'=> true], ['createdAt' => 'DESC']),
            'categories' => $categoryRepository->findAll()
        ]);
    }


     /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function mentionsLegales()
    {
        // Nous générons la vue de la page des mentions légales
        return $this->render('main/mentions-legales.html.twig');
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu()
    {
        // Nous générons la vue de la page des mentions légales
        return $this->render('main/cgu.html.twig');
    }

     /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        // Nous générons la vue de la page de contact
        return $this->render('main/contact.html.twig');
    }
}
