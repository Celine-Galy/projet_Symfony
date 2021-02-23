<?php

namespace App\Controller;

use DateTime;
use App\Entity\ResponseTo;
use App\Form\ResponseToType;
use App\Entity\ResponseForum;
use App\Repository\ResponseToRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\MessageForum;

/**
 * @Route("/response/to")
 */
class ResponseToController extends AbstractController
{
    /**
     * @Route("/", name="response_to_index", methods={"GET"})
     */
    public function index(ResponseToRepository $responseToRepository): Response
    {
        return $this->render('response_to/index.html.twig', [
            'response_tos' => $responseToRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="response_to_new", methods={"GET","POST"})
     */
    public function new(ResponseForum $responseForum, Request $request): Response
    {
        $responseTo = new ResponseTo();
        $form = $this->createForm(ResponseToType::class, $responseTo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseTo ->setAuthor($this->getUser())
                        ->setCreatedAt(new DateTime())
                        ->setResponseForum($responseForum);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($responseTo);
            $entityManager->flush();

            return $this->redirectToRoute('message_forum_show',['id' => $responseForum->getInitialMessage()->getId()]);
        }

        return $this->render('response_to/new.html.twig', [
            'response_to' => $responseTo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="response_to_show", methods={"GET"})
     */
    public function show(ResponseTo $responseTo): Response
    {
        return $this->render('response_to/show.html.twig', [
            'response_to' => $responseTo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="response_to_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ResponseTo $responseTo): Response
    {
        $form = $this->createForm(ResponseToType::class, $responseTo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('response_to_index');
        }

        return $this->render('response_to/edit.html.twig', [
            'response_to' => $responseTo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="response_to_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ResponseTo $responseTo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responseTo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($responseTo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('response_to_index');
    }
}
