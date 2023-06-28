<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/ui')]
class UiController extends AbstractController
{
    #[Route('/{session}', name: 'app_ui')]
    public function index(Session $session): Response
    {
        return $this->render('ui/index.html.twig', [
            'data' => json_encode($session->getTemplate()->getData()),
            'persona' => $session->getPersona(),
        ]);
    }
}
