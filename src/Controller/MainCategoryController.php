<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/main_category")
 */
class MainCategoryController extends AbstractController
{
    /**
     * @Route("/{id}", name="main_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        
        return $this->render('main_category/show.html.twig', [
            'articles' => $category->getArticles(),
            'category' => $category
        ]);
    }

}

