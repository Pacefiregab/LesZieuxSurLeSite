<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tracking')]
class TrackingController extends AbstractController
{
    #[Route('/', name: 'app_tracking', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('tracking/index.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }

    #[Route('/create', name: 'create_tracking', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('tracking/create.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }

    #[Route('/create', name: 'create_tracking_post', methods: ['POST'])]
    public function add(): Response
    {
        return $this->render('tracking/create.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_tracking', methods: ['GET'])]
    public function edit(): Response
    {
        return $this->render('tracking/edit.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_tracking_put', methods: ['PUT'])]
    public function modify(): Response
    {
        return $this->render('tracking/edit.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_tracking', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->render('tracking/delete.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }

    #[Route('/show/{id}', name: 'show_tracking', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('tracking/show.html.twig', [
            'controller_name' => 'TrackingController',
        ]);
    }


}
