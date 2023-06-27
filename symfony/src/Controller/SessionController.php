<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/session')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'index_session', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    #[Route('/create', name: 'create_session', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('session/create.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    #[Route('/create', name: 'create_session', methods: ['POST'])]
    public function add(): Response
    {
        return $this->render('session/create.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_session', methods: ['GET'])]
    public function edit(): Response
    {
        return $this->render('session/edit.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_session_post', methods: ['PUT'])]
    public function modify(): Response
    {
        return $this->render('session/edit.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_session', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->render('session/delete.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }

    #[Route('/show/{id}', name: 'show_session', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('session/show.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
}
