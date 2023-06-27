<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/ui')]
class UiController extends AbstractController
{
    #[Route('/', name: 'app_ui')]
    public function index(): Response
    {
        return $this->render('ui/index.html.twig', []);
    }
}
