<?php

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(PaginatorInterface $paginator, Request $request, CategoryRepository $categoryRepository): Response
    {   // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Article::class)->findBy(['published'=>true],['createdAt' => 'desc']);

        $articles = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );
        
        return $this->render('main/index.html.twig', [
            'articles' => $articles,
            'categories' => $categoryRepository->findAll(),
          
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
