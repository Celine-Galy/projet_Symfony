<?php

namespace App\Controller;

use DateTime;
use App\Entity\MessageForum;
use App\Form\MessageForumType;
use App\Repository\MessageForumRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MessageForumController extends AbstractController
{
    /**
     * @Route("/message/forum/", name="message_forum_index", methods={"GET"})
     */
    public function index(MessageForumRepository $messageForumRepository): Response
    {
        return $this->render('message_forum/index.html.twig', [
            'message_forums' => $messageForumRepository->findBy([],['id'=>'DESC'],5),
        ]);
    }

    /**
     * @Route("/message/forum/new", name="message_forum_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $messageForum = new MessageForum();
        $form = $this->createForm(MessageForumType::class, $messageForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $messageForum->setAuthor($this->getUser())
                         ->setCreatedAt(new DateTime())
                         ->setUpdatedAt(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($messageForum);
            $entityManager->flush();

            return $this->redirectToRoute('message_forum_index');
        }

        return $this->render('message_forum/new.html.twig', [
            'message_forum' => $messageForum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/message/forum/{id}", name="message_forum_show", methods={"GET"})
     */
    public function show(MessageForum $messageForum): Response
    {
        return $this->render('message_forum/show.html.twig', [
            'message_forum' => $messageForum,
            'response_forums'=> $messageForum->getResponseForums(),
        ]);
    }

    /**
     * @Route("/message/forum/{id}/edit", name="message_forum_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MessageForum $messageForum): Response
    {
        $form = $this->createForm(MessageForumType::class, $messageForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_forum_index');
        }

        return $this->render('message_forum/edit.html.twig', [
            'message_forum' => $messageForum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/message/forum/{id}", name="message_forum_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MessageForum $messageForum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageForum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($messageForum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_forum_index');
    }

}
