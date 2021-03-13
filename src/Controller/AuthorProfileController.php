<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorProfileController extends AbstractController
{
    /**
     * @Route("/author/profile", name="author_profile")
     */
    public function index(): Response
    {
        return $this->render('author_profile/index.html.twig', [
            'controller_name' => 'AuthorProfileController',
        ]);
    }

    /**
     * @Route("/author/profile/{id}", name="author_profile_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('author_profile/show.html.twig', [
            
            'author' => $user,
        ]);
    }
}
