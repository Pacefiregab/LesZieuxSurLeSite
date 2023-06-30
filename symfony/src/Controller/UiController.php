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
            'data' => $session->getTemplate()->getData(),
            'persona' => $session->getPersona(),
        ]);
    }

    #[Route('/{session}/heatmap', name: 'app_ui_heatmap')]
    public function heatmap(Session $session): Response
    {
        $data = $session->getTemplate()->getData();
        $data ["stickyHeader"] = false;
        return $this->render('ui/index.html.twig', [
            'data' => $data,
            'persona' => $session->getPersona(),
            'heatmap' => true,
            'heatmapData' => '[{ x: 10, y: 15, value: 5 },{ x: 20, y: 25, value: 8 },]' /*$session->getHeatmapData()*/,
        ]);
    }
}
