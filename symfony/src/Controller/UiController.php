<?php

namespace App\Controller;


use App\Entity\Persona;
use App\Entity\Session;
use App\Entity\Template;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\Tracking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/ui')]
class UiController extends AbstractController
{
    #[Route(['/{session}','/'] ,name: 'app_ui')]
    public function index(?Session $session, EntityManagerInterface $entityManager): Response {
        if (!$session->getId()) {
            $personas = $entityManager->getRepository(Persona::class)->findAll();
            $persona = $personas[array_rand($personas)];
            $templates = $entityManager->getRepository(Template::class)->findAll();
            $template = $templates[array_rand($templates)];
            $session->setTemplate($template);
            $session->setPersona($persona);
        }
        return $this->render('ui/index.html.twig', [
            'data' => $session->getTemplate()?->getData() ?? [],
            'persona' => $session->getPersona(),
            'session' => $session,
        ]);
    }

    #[Route('/{session}/heatmap', name: 'app_ui_heatmap')]
    public function heatmap(Session $session): Response
    {
        $data = $session->getTemplate()->getData();
        $data ["stickyHeader"] = false;

        foreach ($session->getTrackings() as $tracking) {
            $varType = Tracking::TYPES[$tracking->getType()];
            $$varType = $$varType ?? [];
            foreach ($tracking->getData() as $pos) {
                $$varType[] = [
                    'x' => $pos['x'] ?? $pos['X'],
                    'y' => $pos['y'] ?? $pos['Y'],
                    'value' => $tracking->getType() === Tracking::TYPE_CLICK ? 20 : ($tracking->getType() === Tracking::TYPE_MOUSE ? 3 : 1),
                ];
            }
        }

        return $this->render('ui/index.html.twig', [
            'data' => $data,
            'persona' => $session->getPersona(),
            'session' => $session,
            'heatmap' => true,
            'heatmapDataEye' => $heatmapDataEye ?? [],
            'heatmapDataClick' => $heatmapDataClick ?? [],
            'heatmapDataScroll' => $heatmapDataScroll ?? [],
            'heatmapDataMouse' => $heatmapDataMouse ?? [],
        ]);
    }
}
