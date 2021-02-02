<?php

namespace App\Controller;

use DateTime;
use App\Entity\Message;
use App\Entity\Subject;
use App\Form\ResponseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/response")
 */
class ResponseController extends AbstractController
{
    /**
     * @Route("/", name="response")
     */
    public function index(): Response
    {
        return $this->render('response/index.html.twig', [
            'controller_name' => 'ResponseController',
        ]);
    }

    /**
     * @Route("/new/{id}", name="response_new", methods={"GET","POST"})
     */
    public function new(Message $message, Subject $subject, Request $request): Response
    {
        $response = new Message();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response->setCreatedAt(new DateTime());
            $response->setAuthor($this->getUser());
            $response->setSubject($subject);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($response);
            $entityManager->flush();
            return $this->redirectToRoute('message_show', ['id' => $subject->getId()]);
        }
        return $this->render('response/new.html.twig', [
            'subject' => $subject,
            'message' => $message,
            'form'    => $form->createView()
        ]);
    }
}
