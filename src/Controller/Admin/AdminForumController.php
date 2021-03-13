<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminForumController extends AbstractController
{
    /**
     * @Route("/admin/forum", name="admin_forum")
     */
    public function index(): Response
    {
        return $this->render('admin_forum/index.html.twig', [
            'controller_name' => 'AdminForumController',
        ]);
    }
}
