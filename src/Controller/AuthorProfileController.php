<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\BiographyType;
use App\Form\TwitchChannelType;
use Symfony\Component\HttpFoundation\Request;
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

     /**
     * @Route("/author/editBiography/{id}", name="author_biography", methods={"GET","POST"})
     */
    public function biography(User $user, Request $request): Response
    {
        $form = $this->createForm(BiographyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             $this->addFlash(
            'notice',
            'Ta bio a bien été mise à jour!'
        );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('author_profile_show',['id'=> $user->getId()]);
        }

        return $this->render('author_profile/editBiography.html.twig', [
            'author' => $user,
            'form' => $form->createView(),
        ]);
    }
      /**
     * @Route("/author/editTwitchChannel/{id}", name="author_channel", methods={"GET","POST"})
     */
    public function channel(User $user, Request $request): Response
    {
        $form = $this->createForm(TwitchChannelType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             $this->addFlash(
            'notice',
            'Ta chaîne Twitch a bien été ajouté!'
        );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('author_profile_show',['id'=> $user->getId()]);
        }

        return $this->render('author_profile/editTwitchChannel.html.twig', [
            'author' => $user,
            'form' => $form->createView(),
        ]);
    }
}
