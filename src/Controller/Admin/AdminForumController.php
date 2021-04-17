<?php

namespace App\Controller\Admin;

use App\Entity\MessageForum;
use Symfony\Component\Mime\Message;
use App\Repository\MessageForumRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/forum")
 */
class AdminForumController extends AbstractController
{
    /**
     * @Route("/", name="admin_forum")
     */
    public function index(MessageForumRepository $messageForumRepository): Response
    {
        return $this->render('admin/admin_forum/index.html.twig', [
            'message_forums' => $messageForumRepository->findAll(),
        ]);
    }
       /**
     * @Route("/{id}", name="message_forum_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MessageForum $messageForum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messageForum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($messageForum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_forum');
    }
}
