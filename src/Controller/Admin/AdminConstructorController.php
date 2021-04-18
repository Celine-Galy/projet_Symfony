<?php

namespace App\Controller\Admin;

use App\Entity\Constructor;
use App\Form\ConstructorType;
use App\Repository\ConstructorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/constructor")
 */
class AdminConstructorController extends AbstractController
{
    /**
     * @Route("/", name="admin_constructor")
     */
    public function index(ConstructorRepository $constructorRepository): Response
    {
        return $this->render('admin/admin_constructor/index.html.twig', [
            'constructors' => $constructorRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="constructor_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $constructor = new Constructor();
        $form = $this->createForm(ConstructorType::class, $constructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
            }
            $constructor->setCover($fichier);
            $this->addFlash(
                'notice',
                'Le constructeur a bien été ajouté!'
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($constructor);
            $entityManager->flush();

            return $this->redirectToRoute('admin_constructor');
        }

        return $this->render('admin/admin_constructor/new.html.twig', [
            'constructor' => $constructor,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="constructor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Constructor $constructor): Response
    {
        $form = $this->createForm(ConstructorType::class, $constructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                if ($images != null) {
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );

                    $constructor->setCover($fichier);
                }
            }
             $this->addFlash(
                'notice',
                'Le constructeur a bien été modifié!'
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_constructor');
        }
        return $this->render('admin/admin_constructor/edit.html.twig', [
            'constructor' => $constructor,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="constructor_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Constructor $constructor): Response
    {
        if ($this->isCsrfTokenValid('delete' . $constructor->getId(), $request->request->get('_token'))) {
              $this->addFlash(
                'notice',
                'Le constructeur a bien été supprimé!'
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($constructor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_constructor');
    }
}
