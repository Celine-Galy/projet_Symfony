<?php

namespace App\Controller;

use App\Entity\Constructor;
use App\Repository\ConstructorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/constructor")
 */
class ConstructorController extends AbstractController
{
    /**
     * @Route("/", name="constructor_index", methods={"GET","POST"})
     */
    public function index(ConstructorRepository $constructorRepository): Response
    {

        return $this->render('console/index.html.twig', [
            'constructors' => $constructorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="constructor_show", methods={"GET"})
     */
    public function show(Constructor $constructor): Response
    {
        return $this->render('constructor/show.html.twig', [
            'constructor' => $constructor
        ]);
    }
}
