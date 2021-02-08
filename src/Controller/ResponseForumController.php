<?php

namespace App\Controller;

use App\Entity\MessageForum;
use App\Entity\ResponseForum;
use App\Form\ResponseForumType;
use App\Repository\ResponseForumRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/response/forum")
 */
class ResponseForumController extends AbstractController
{
    /**
     * @Route("/", name="response_forum_index", methods={"GET"})
     */
    public function index(ResponseForumRepository $responseForumRepository): Response
    {
        return $this->render('response_forum/index.html.twig', [
            'response_forums' => $responseForumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="response_forum_new", methods={"GET","POST"})
     */
    public function new(MessageForum $messageForum, Request $request): Response
    {
        $responseForum = new ResponseForum();
        $form = $this->createForm(ResponseForumType::class, $responseForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseForum->setAuthor($this->getUser())
                          ->setCreatedAt(new DateTime())
                          ->setInitialMessage($messageForum);
                          
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($responseForum);
            $entityManager->flush();

            return $this->redirectToRoute('message_forum_show',['id' => $messageForum->getId()]);
        }

        return $this->render('response_forum/new.html.twig', [
            'response_forum' => $responseForum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="response_forum_show", methods={"GET"})
     */
    public function show(ResponseForum $responseForum): Response
    {
        return $this->render('response_forum/show.html.twig', [
            'response_forum' => $responseForum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="response_forum_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ResponseForum $responseForum): Response
    {
        $form = $this->createForm(ResponseForumType::class, $responseForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('response_forum_index');
        }

        return $this->render('response_forum/edit.html.twig', [
            'response_forum' => $responseForum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="response_forum_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ResponseForum $responseForum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responseForum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($responseForum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('response_forum_index');
    }
}
