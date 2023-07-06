<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Entity\Session;
use App\Entity\Template;
use App\Form\TemplateType;
use App\Repository\SessionRepository;
use App\Repository\TemplateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/templates')]
class TemplateController extends AbstractController
{
    private TemplateRepository $templateRepository;

    private SessionRepository $sessionRepository;

    public function __construct(
        TemplateRepository $templateRepository,
        SessionRepository $sessionRepository
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->templateRepository = $templateRepository;
    }

    #[Route('/', name: 'templates_index', methods: 'GET')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $templates = $entityManager->getRepository(Template::class)->findAll();

        if (sizeof($templates)<1){
            $templates = [new Template()];
        }
        return $this->render('template/index.html.twig', [
            'templates' => $templates,
        ]);
    }

    #[Route('/create', name: 'templates_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $template = new Template();
        $formData = $request->request;
        $data = [
            "stickyHeader" => $formData->getBoolean('stickyHeader'),
            "reverseRows" => $formData->getBoolean('reverseRows'),
            "specialButtonForTicket" => $formData->getBoolean('specialButtonForTicket'),
            "contactMapFirst" => $formData->getBoolean('contactMapFirst'),
            "changeCheckBoxSelect" => $formData->getBoolean('changeCheckBoxSelect'),
            "whiteColor" => $formData->get('whiteColor'),
            "darkColor" => $formData->get('darkColor'),
            "primaryColor" => $formData->get('primaryColor'),
            "secondaryColor" => $formData->get('secondaryColor'),
        ];
        $template
            ->setData($data)
            ->setName($formData->get('name'));

        $entityManager->persist($template);
        $entityManager->flush();
        return $this->redirectToRoute('templates_index');
    }


    #[Route('/{id}/edit', name: 'templates_edit', methods: ['POST'])]
    public function edit(Request $request, Template $template, EntityManagerInterface $entityManager): Response
    {
        $formData = $request->request;
        $data = [
            "stickyHeader" => $formData->getBoolean('stickyHeader'),
            "reverseRows" => $formData->getBoolean('reverseRows'),
            "specialButtonForTicket" => $formData->getBoolean('specialButtonForTicket'),
            "contactMapFirst" => $formData->getBoolean('contactMapFirst'),
            "changeCheckBoxSelect" => $formData->getBoolean('changeCheckBoxSelect'),
            "whiteColor" => $formData->get('whiteColor'),
            "darkColor" => $formData->get('darkColor'),
            "primaryColor" => $formData->get('primaryColor'),
            "secondaryColor" => $formData->get('secondaryColor'),
        ];
        $template
            ->setData($data)
            ->setName($formData->get('name'));

        $entityManager->flush();
        return $this->redirectToRoute('templates_index');
    }

    #[Route('/', name: 'templates_delete', methods: 'DELETE')]
    public function delete(Request $request, Template $template): Response
    {
        if ($this->isCsrfTokenValid('delete' . $template->getId(), $request->request->get('_token'))) {
            $this->templateRepository->remove($template);
        }

        return $this->redirectToRoute('templates_index');
    }

    #[Route('/details', name: 'templates_details', methods: 'GET')]
    public function details(EntityManagerInterface $entityManager): Response
    {
        $templates = $entityManager->getRepository(Template::class)->findAll();

        return $this->render('template/details.html.twig', [
            'templates' => $templates,
        ]);
    }

    #[Route('/form')]
    #[Route('/form/{id}', name: 'template_form_get', methods: ['GET'])]
    public function form(?Template $template): JsonResponse
    {
        $template = $template ?? new Template();
        $html = $this->renderView('template/form.html.twig', [
            'template' => $template,
        ]);

        return new JsonResponse([
            'html' => $html,
        ]);
    }


    #[Route('/api/{id}', name: 'templates_api', methods: 'GET')]
    public function api(Template $template): JsonResponse
    {
        $sessions = $this->sessionRepository->findBy(['template' => $template]);
        $personas = [];
        $personasSessions = [];
        $statistics = [];
        $clicks = [];

        foreach ($sessions as $session) {
            $personasSessions[$session->getPersona()->getId()][] = $session;
            $personas[] = $session->getPersona();
            foreach ($session->getTrackings() as $trackings) {
               if($trackings->getType() == 'click') {
                   $clicks[]= count($trackings->getData());
               }
            }
        }

        foreach ($personas as $persona) {
            $personaSessions = $personasSessions[$persona->getId()];

            $personaStats = [
                'name' => $persona->getName(),
                'sessions' => [
                    'total' => count($personaSessions),
                    'isSuccess' => count(array_filter($personaSessions, function ($session) {
                        return $session->getIsSuccess();
                    })),
                    'averageTime' => count($personaSessions) > 0 ? array_sum(array_map(function ($session) {
                        return ($session->getDateEnd() != null || $session->getDateStart() != null) ? $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp() : 0;
                    }, $personaSessions)) / count($personaSessions) : 0,
                    'minTime' => count($personaSessions) > 0 ? min(array_map(function ($session) {
                        return ($session->getDateEnd() != null || $session->getDateStart() != null) ? $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp() : 0;
                    }, $personaSessions)) : 0,
                    'maxTime' => count($personaSessions) > 0 ? max(array_map(function ($session) {
                        return ($session->getDateEnd() != null || $session->getDateStart() != null) ? $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp() : 0;
                    }, $personaSessions)) : 0,
                ],
            ];
            $statistics[$persona->getId()] = $personaStats;
        }

        $templateStatistics = [
            'nbSessions' => count($sessions),
            'nbSuccess' => count(array_filter($sessions, function ($session) {
                return $session->getIsSuccess();
            })),
            'averageTime' => count($sessions) > 0 ? array_sum(array_map(function ($session) {
                return ($session->getDateEnd() != null || $session->getDateStart() != null) ? $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp() : 0;
            }, $sessions)) / count($sessions) : 0,
            'minTime' => count($sessions) > 0 ? min(array_map(function ($session) {
                return ($session->getDateEnd() != null || $session->getDateStart() != null) ? $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp() : 0;
            }, $sessions)) : 0,
            'maxTime' => count($sessions) > 0 ? max(array_map(function ($session) {
                return ($session->getDateEnd() != null || $session->getDateStart() != null) ? $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp() : 0;
            }, $sessions)) : 0,
            'averageClicks' => count($sessions) > 0 ? array_sum($clicks) / count($sessions) : 0,
            'minClicks' => count($sessions) > 0 ? min($clicks) : 0,
            'maxClicks' => count($sessions) > 0 ? max($clicks) : 0,
        ];


        $template = [
            'id' => $template->getId(),
            'name' => $template->getName(),
            'data' => $template->getData(),
            'templateStatistics' => $templateStatistics,
            'personasStatistics' => $statistics,
        ];

        return new JsonResponse($template);
    }


    #[Route('/{id}/sessions', name: 'templates_show_sessions', methods: 'GET')]
    public function show(Template $template): Response
    {
        $sessions = $this->sessionRepository->findBy(['template' => $template]);

        return $this->render('template/show.html.twig', [
            'template' => $template,
            'sessions' => $sessions
        ]);
    }
}
