<?php

namespace App\Controller;

use DateTime;
use App\Entity\MessageForum;
use App\Entity\ResponseLike;
use App\Entity\ResponseForum;
use App\Form\ResponseForumType;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ResponseLikeRepository;
use App\Repository\ResponseForumRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ResponseForumController extends AbstractController
{
    /**
     * @Route("/response/forum/", name="response_forum_index", methods={"GET"})
     */
    public function index(ResponseForumRepository $responseForumRepository): Response
    {
        return $this->render('response_forum/index.html.twig', [
            'response_forums' => $responseForumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/response/forum/new/{id}", name="response_forum_new", methods={"GET","POST"})
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
     * @Route("/response/forum/{id}", name="response_forum_show", methods={"GET"})
     */
    public function show(ResponseForum $responseForum): Response
    {
        return $this->render('response_forum/show.html.twig', [
            'response_forum' => $responseForum,
            
        ]);
    }

    /**
     * @Route("/response/forum/{id}/edit", name="response_forum_edit", methods={"GET","POST"})
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
     * @Route("/response/forum/{id}", name="response_forum_delete", methods={"DELETE"})
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

    /**
     * Permet de liker ou unliker un article
     * 
     * @Route("/response/forum/{id}/like", name="like_response") 
     * 
     * @param ResponseForum $responseForum
     * @param ObjectManager $manager
     * @param ResponseLikeRepository $likeRepo
     * @return Response
     */
    public function like(ResponseForum $responseForum, ObjectManager $manager, ResponseLikeRepository $likeRepo) : Response
    {
        $user = $this->getUser();
        if(!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);
        
        if($responseForum->isLikedByUser($user)){
            $like = $likeRepo->findOneBy([
                'responseForum'=> $responseForum,
                'user'=> $user
            ]);
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepo->count([
                    'responseForum' => $responseForum
                ])
            ], 200);
        }
        $like = new ResponseLike();
        $like->setResponseForum($responseForum)
             ->setUser($user);
            
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code'=> 200, 
            'message' => 'Like bien ajouté',
            'likes' => $likeRepo->count(['responseForum' => $responseForum])
        ], 200);
    }
}
