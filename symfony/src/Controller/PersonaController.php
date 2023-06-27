<?php

namespace App\Controller;

use App\Entity\Persona;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/persona')]
class PersonaController extends AbstractController
{
    #[Route('/', name: 'index_persona', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('persona/index.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/create', name: 'create_persona', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('persona/create.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/create', name: 'add_persona', methods: ['POST'])]
    public function add(): Response
    {
        return $this->render('persona/create.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_persona', methods: ['GET'])]
    public function edit(): Response
    {
        return $this->render('persona/edit.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_persona', methods: ['POST'])]
    public function modify(): Response
    {
        return $this->render('persona/edit.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_persona', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->render('persona/delete.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/show/{id}', name: 'show_persona', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('persona/show.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    #[Route('/api/{id}', name: 'api_index_persona', methods: ['GET'])]
    public function apiIndex(): JsonResponse
    {
        $data = [
            'nombreSessions' => rand(0, 10),
            'tauxSucces' => rand(-100, 100),
            'nombreInterfaces' => rand(0, 10),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

}
