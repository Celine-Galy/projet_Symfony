<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserType;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(UserRepository $users): Response
    {
        return $this->render('admin/admin_user/index.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="admin_modify_user")
     */
    public function modifyUser(User $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_user');
        }
        return $this->render('admin/admin_user/modifyUser.html.twig',[
            'userForm' => $form->createView(),
        ]);
    }
}
