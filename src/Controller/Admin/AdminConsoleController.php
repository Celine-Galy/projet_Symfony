<?php

namespace App\Controller\Admin;

use App\Entity\Console;
use App\Repository\ConsoleRepository;
use App\Form\ConsoleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin/console")
 */
class AdminConsoleController extends AbstractController
{
    /**
     * @Route("/", name="admin_console")
     */
    public function indexConsole(ConsoleRepository $consoleRepository): Response
    {
        return $this->render('admin/admin_console/index.html.twig', [
            'consoles' => $consoleRepository->findAll(),
        ]);
    }

     /**
     * @Route("/new", name="console_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $console = new Console();
        $form = $this->createForm(ConsoleType::class, $console);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier);
            }
            $console->setCover($fichier);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($console);
            $entityManager->flush();

            return $this->redirectToRoute('admin_console');
        }

        return $this->render('admin/admin_console/new.html.twig', [
            'console' => $console,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_console_show", methods={"GET"})
     */
    public function show(Console $console): Response
    {
        return $this->render('admin/admin_console/show.html.twig', [
            'console' => $console,
            'constructor' => $console->getConstructor()
        ]);
    }

      /**
     * @Route("/{id}/edit", name="console_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Console $console): Response
    {
        $form = $this->createForm(ConsoleType::class, $console);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach($images as $image){
                if($images !=null){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()).'.'.$image->guessExtension();
            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier);

            $console ->setCover($fichier);
            }
        } 
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_console');
        }

        return $this->render('admin/admin_console/edit.html.twig', [
            'console' => $console,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="console_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Console $console): Response
    {
        if ($this->isCsrfTokenValid('delete'.$console->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($console);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_console');
    }
}
