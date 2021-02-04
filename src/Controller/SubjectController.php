<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Subject;
use App\Form\MessageEditType;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subject")
 */
class SubjectController extends AbstractController
{
    /**
     * @Route("/", name="subject_index", methods={"GET"})
     */
    public function index(SubjectRepository $subjectRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'subjects' => $subjectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="subject_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('subject_index');
        }

        return $this->render('subject/new.html.twig', [
            'subject' => $subject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Subject $subject): Response
    {
        return $this->render('message/show.html.twig', [
            'subject' => $subject,
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageEditType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->getSubject();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subject_index');
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/{id}", name="message_delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, Message $message): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($message);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('subject_index');
    // }
}
