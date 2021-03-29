<?php

namespace App\Controller;

use App\Entity\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/console")
 */
class ConsoleController extends AbstractController
{

    /**
     * @Route("/{id}", name="console_show", methods={"GET"})
     */
    public function show(Console $console): Response
    {
        return $this->render('console/show.html.twig', [
            'console' => $console,
        ]);
    }

  
}
