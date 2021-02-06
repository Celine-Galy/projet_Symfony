<?php

namespace App\Controller;

use DateTime;
use App\Entity\Message;
use App\Entity\Subject;
use App\Form\MessageType;
use App\Entity\ArticleLike;
use App\Entity\MessageLike;
use Doctrine\Persistence\ObjectManager;
use App\Repository\MessageLikeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MessageController extends AbstractController
{

    /**
     * @Route("/message/new", name="message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = new Subject();
            $subject -> setTitle($form->get('subject')->getData());
            $message->setAuthor($this->getUser());
            $message->setCreatedAt(new DateTime());
            
            $message->setSubject($subject);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush($message);

            return $this->redirectToRoute('subject_index');
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("message/{id}", name="message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subject_index');
    }

      /**
     * Permet de liker ou unliker un article
     * 
     * @Route("/message/{id}/like", name="like_message") 
     * 
     * @param Message $message
     * @param ObjectManager $manager
     * @param MessageLikeRepository $likeRepo
     * @return Response
     */
    public function like(Message $message, ObjectManager $manager, MessageLikeRepository $likeRepo) : Response
    {
        $user = $this->getUser();
        if(!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);
        
        if($message->isLikedByUser($user)){
            $like = $likeRepo->findOneBy([
                'message'=> $message,
                'user'=> $user
            ]);
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepo->count([
                    'message' => $message
                ])
            ], 200);
        }
        $like = new MessageLike();
        $like->setMessage($message)
             ->setUser($user);
            
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code'=> 200, 
            'message' => 'Like bien ajouté',
            'likes' => $likeRepo->count(['message' => $message])
        ], 200);
    }
}
