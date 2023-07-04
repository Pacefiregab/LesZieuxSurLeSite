<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sessions')]
class SessionController extends AbstractController
{
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }


    #[Route('/', name: 'session_index', methods: 'GET')]
    public function index(): Response
    {
        $sessions = $this->sessionRepository->findAll();

        return $this->render('sessions/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }


    #[Route('/create', name: 'session_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sessionRepository->save($session);

            return $this->redirectToRoute('sessions_index');
        }

        return $this->render('sessions/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'session', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sessionRepository->save($session);

            return $this->redirectToRoute('sessions_index');
        }

        return $this->render('sessions/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'templates_delete', methods: 'DELETE')]
    public function delete(Session $session): Response
    {
        $this->sessionRepository->remove($session, true);


        return $this->redirectToRoute('sessions_index');
    }

    #[Route('/{id}', name: 'templates_show', methods: 'GET')]
    public function show(Session $session): Response
    {
        return $this->render('sessions/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/api/{id}', name: 'api_index_session', methods: 'GET')]
    public function api(Session $session): JsonResponse
    {
        //Actual session data
        $scroll = 0;
        $clicks = 0;
        foreach ($session->getTrackings() as $tracking) {
            if ($tracking->getType() === 'click') {
                $clicks += count($tracking->getData());
                continue;
            }
        }
        foreach ($session->getTrackings() as $tracking) {
            if ($tracking->getType() === 'scroll') {
                $scroll += count($tracking->getData());
                continue;
            }
        }

        //Template of the session data
        $sessionsTemplate = $this->sessionRepository->findBy(['template' => $session->getTemplate()]);
        $sessionTemplateTimes = [];
        $sessionTemplateSuccess = [];
        $templateScroll = 0;
        $templateClicks = 0;
        foreach ($sessionsTemplate as $templateSession) {
            $sessionTemplateTimes[] = $templateSession->getDateEnd()->getTimestamp() - $templateSession->getDateStart()->getTimestamp();
            $sessionTemplateSuccess[] = $templateSession->getIsSuccess();
            foreach ($templateSession->getTrackings() as $tracking) {
                if ($tracking->getType() === 'click') {
                    $templateClicks += count($tracking->getData());
                    continue;
                }
            }
            foreach ($templateSession->getTrackings() as $tracking) {
                if ($tracking->getType() === 'scroll') {
                    $templateScroll += count($tracking->getData());
                    continue;
                }
            }
        }
        /* dd($templateClicks, $templateScroll, $sessionTemplateTimes, $sessionTemplateSuccess, count($sessionsTemplate)); */

        //Persona of the session data
        $sessionsPersona = $this->sessionRepository->findBy(['persona' => $session->getPersona()]);
        $sessionPersonaTimes = [];
        $sessionPersonaSuccess = [];
        $personaScroll = 0;
        $personaClicks = 0;
        foreach ($sessionsPersona as $personaSession) {
            $sessionPersonaTimes[] = $personaSession->getDateEnd()->getTimestamp() - $personaSession->getDateStart()->getTimestamp();
            $sessionPersonaSuccess[] = $personaSession->getIsSuccess();
            foreach ($personaSession->getTrackings() as $tracking) {
                if ($tracking->getType() === 'click') {
                    $personaClicks += count($tracking->getData());
                    continue;
                }
            }
            foreach ($personaSession->getTrackings() as $tracking) {
                if ($tracking->getType() === 'scroll') {
                    $personaScroll += count($tracking->getData());
                    continue;
                }
            }
        }

        //Global data array
        $data = [
            'sessionDate' => $session->getDateStart()->format('d/m/Y'),
            'sessionTime' => $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp(),
            'isSuccess' => $session->getIsSuccess(),
            'sessionName' => $session->getTitle(),
            'graph'  => [
                $clicks,
                $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp(),
                0
            ],
            'template' => [
                'name' => $session->getTemplate()->getName(),
                'avgTime' => count($sessionsTemplate) > 0 ? array_sum($sessionTemplateTimes) / count($sessionsTemplate) : 0,
                'maxTime' => max($sessionTemplateTimes),
                'minTime' => min($sessionTemplateTimes),
                'successRate' => count($sessionsTemplate) > 0 ? array_sum($sessionTemplateSuccess) / count($sessionsTemplate) : 0,
                'count' => count($sessionsTemplate),
                'graph' => [
                    count($sessionsTemplate) > 0 ? $templateClicks / count($sessionsTemplate) : 0,
                    count($sessionsTemplate) > 0 ? array_sum($sessionTemplateTimes) / count($sessionsTemplate) : 0,
                    0
                ],
                'clicks' => $templateClicks,
            ],
            'persona' => [
                'name' => $session->getPersona()->getName(),
                'avgTime' => count($sessionsPersona)  > 0 ? array_sum($sessionPersonaTimes) / count($sessionsPersona) : 0,
                'maxTime' => max($sessionPersonaTimes),
                'minTime' => min($sessionPersonaTimes),
                'successRate' => count($sessionsPersona) > 0 ? array_sum($sessionPersonaSuccess) / count($sessionsPersona) : 0,
                'count' => count($sessionsPersona),
                'graph' => [
                    count($sessionsPersona)  > 0 ? $personaClicks / count($sessionsPersona) : 0,
                    count($sessionsPersona)  > 0 ? array_sum($sessionPersonaTimes) / count($sessionsPersona) : 0,
                    0
                ],
            ],
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
