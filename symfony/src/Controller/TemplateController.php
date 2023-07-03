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
use Symfony\Component\Routing\Annotation\Route; #

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
            "stickyHeader" => $formData->get('stickyHeader'),
            "reverseRows" => $formData->get('reverseRows'),
            "specialButtonForTicket" => $formData->get('specialButtonForTicket'),
            "contactMapFirst" => $formData->get('contactMapFirst'),
            "changeCheckBoxSelect" => $formData->get('changeCheckBoxSelect'),
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
            "stickyHeader" => $formData->get('stickyHeader'),
            "reverseRows" => $formData->get('reverseRows'),
            "specialButtonForTicket" => $formData->get('specialButtonForTicket'),
            "contactMapFirst" => $formData->get('contactMapFirst'),
            "changeCheckBoxSelect" => $formData->get('changeCheckBoxSelect'),
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

    #[Route('/{id}', name: 'templates_show', methods: 'GET')]
    public function show(Template $template): Response
    {
        return $this->render('templates/show.html.twig', [
            'template' => $template,
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
    #[Route('/{id}/details', name: 'templates_details', methods: 'GET')]
    public function details(Template $template): JsonResponse
    {
        $sessions = $this->sessionRepository->findBy(['template' => $template]);
        $personas = [];
        $statistics = [];
        /*
        foreach ($sessions as $session) {
            $persona = $session->getPersona();

        foreach ($sessions as $session) {
            $personas[$session->getPersona()->getId()][] = $session;
        }

        foreach ($personas as $persona) {
            $statistics[$persona->getPersona()->getId()] = [
                'id' => $persona->getPersona()->getId(),
                'name' => $persona->getPersona()->getName(),
                'sessions' => [
                    'total' => $personas[$persona->getPersona()->getId()]/*
                    'isSuccess' => $personas[$persona->getPersona()->getId()]->filter(function ($session) {
                        return $session->getIsSucces();
                    }),
                    'averageTime' => $personas[$persona->getPersona()->getId()]->map(function ($session) {
                        return $session->getDuration();
                    })->average(),
                    'minTime' => $personas[$persona->getPersona()->getId()]->map(function ($session) {
                        return $session->getDuration();
                    })->min(),
                    'maxTime' => $personas[$persona->getPersona()->getId()]->map(function ($session) {
                        return $session->getDuration();
                    })->max(),
                ],
            ];
        }
        */
        dd($personas, $statistics);
        $templateStatistics = [
            'id' => $template->getId(),
            'name' => $template->getName(),
            'data' => $template->getData(),
            'personas' => [],
        ];


        $template = [
            'id' => $template->getId(),
            'name' => $template->getName(),
            'data' => $template->getData(),
            'personas' => $personas,
            'statistics' => $templateStatistics,
        ];

        return new JsonResponse($template);
    }
}
