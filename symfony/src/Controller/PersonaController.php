<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/personas')]
class PersonaController extends AbstractController
{
    private PersonaRepository $personaRepository;

        private SessionRepository $sessionRepository;

    protected FormFactoryInterface $formFactory;

    public function __construct(
        PersonaRepository $personaRepository,
        FormFactoryInterface $formFactory,
        SessionRepository $sessionRepository
    ) {
        $this->personaRepository = $personaRepository;
        $this->formFactory = $formFactory;
        $this->sessionRepository = $sessionRepository;
    }

    #[Route('/index', name: 'personas_index', methods: 'GET')]
    public function index(): Response
    {
        $personas = $this->personaRepository->findAll();

        return $this->render('persona/index.html.twig', [
            'personas' => $personas,
        ]);
    }

    #[Route('/create', name: 'personas_create_post', methods: ['POST'])]
    public function add(Request $request): Response
    {
        $data = $request->request->all();

        $form = $this->formFactory->create(PersonaType::class, new Persona());
        $form->submit($data);


        if (!$form->isValid()) {
            dd($form->getErrors());
            return new Response('formulaire invalide : ' . $form->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        $persona = $form->getData();
        $persona->setDuration($persona->getDuration() == null ? 120 : $persona->getDuration());
        $this->personaRepository->save($persona, true);

        return $this->redirectToRoute('personas_index');
    }

    #[Route('/form/{id}', name: 'personas_form_get', methods: ['GET'])]
    public function form(?Persona $persona ): JsonResponse {
        $persona = $persona ?? new Persona();
        $html = $this->renderView('persona/form.html.twig', [
            'persona' => $persona,
        ]);

        return new JsonResponse([
            'html' => $html,
        ]);
    }

    #[Route('/{id}/edit', name: 'personas_edit', methods: ['POST'])]
    public function edit(Request $request, Persona $persona): Response
    {
        $data = $request->request->all();
        $form = $this->formFactory->create(PersonaType::class, $persona);
        $form->submit($data);


        if (!$form->isValid()) {
            dd($form->getErrors());
            return new Response('formulaire invalide : ' . $form->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        $persona = $form->getData();

        $this->personaRepository->save($persona, true);

        return $this->redirectToRoute('personas_index');
    }

    #[Route('/api/{id}', name: 'personas_sessions_info', methods: ['GET'])]
    public function sessionsInfo(Persona $persona): JsonResponse
    {
        $successRate = 0;
        $templates = [];
        $uniqTemplates = [];
        $sessionsTimes = [];

        $sessions = $persona->getSessions();
        foreach ($sessions as $session) {
            $successRate+= $session->getIsSuccess();
            $sessionTime = $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp();
            $uniqTemplates[$session->getTemplate()->getId()] = $session->getTemplate()->getName();

            //maps to the template name the session time
            $templates['#' . $session->getId() . ' - ' . $session->getTemplate()->getName()] = $sessionTime;

            $sessionsTimes[] = $sessionTime;
        }

        $templatesNb = count($uniqTemplates);
        if ($sessions->count() > 0) {
            $successRate = $successRate / $sessions->count() * 100;
        }
        $data = [
            'successRate' => $successRate ?? 0,
            'nbSessions' => $sessions->count(),
            'nbtemplates' => $templatesNb,
            'avgSessions' => $sessionsTimes ? array_sum($sessionsTimes) / count($sessionsTimes) : 0,
            'minSessions' => $sessionsTimes ? min($sessionsTimes) : 0,
            'maxSessions' => $sessionsTimes ? max($sessionsTimes) : 0,
            'graph' => $templates,
            'detail' => $this->generateUrl('personas_show_sessions', ['id' => $persona->getId()]),
        ];

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'personas_delete', methods: 'DELETE')]
    public function delete(Request $request, Persona $persona): Response
    {
        $this->personaRepository->remove($persona, true);

        return $this->redirectToRoute('personas_index');
    }

    #[Route('/{id}/sessions', name: 'personas_show_sessions', methods: 'GET')]
    public function show(Persona $persona): Response
    {
        $sessions = $persona->getSessions();

        return $this->render('persona/show.html.twig', [

            'persona' => $persona,
            'sessions' => $sessions
        ]);
    }
}
