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
        if (!$session) {
            $session = new Session();
            $persona = $entityManager->getRepository(Persona::class)->findOneBy([]);
            $session->setTemplate(new Template());
            $session->setPersona($persona);

            $entityManager->persist($session);
            $entityManager->flush();

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
        $tracking = $session->getTrackings()
            ->filter(function ($tracking) {
                return $tracking->getType() === Tracking::TYPE_EYE;
            })[0]->getData();

        $heatMapData = [];
        foreach ($tracking as $data) {
            $heatMapData[] = [
                'x' => $data['X'],
                'y' => $data['Y'],
                'value' => 1,
            ];
        }

        return $this->render('ui/index.html.twig', [
            'data' => $session->getTemplate()?->getData() ?? [],
            'persona' => $session->getPersona(),
            'session' => $session,
            'heatmap' => true,
            'heatmapData' => $heatMapData
        ]);
    }
}
