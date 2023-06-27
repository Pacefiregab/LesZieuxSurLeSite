<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/template')]
class TemplateController extends AbstractController
{
    #[Route('/', name: 'index_template', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('template/index.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/create', name: 'create_template', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('template/create.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/create', name: 'create_template_add', methods: ['POST'])]
    public function add(): Response
    {
        return $this->render('template/create.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_template', methods: ['GET'])]
    public function edit(int $id): Response
    {
        return $this->render('template/edit.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_template_url', methods: ['PUT'])]
    public function modify(int $id): Response
    {
        return $this->render('template/edit.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_template', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->render('template/delete.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    #[Route('/show/{id}', name: 'show_template', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('template/show.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

}
