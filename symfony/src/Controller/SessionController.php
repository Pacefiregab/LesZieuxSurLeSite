<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Template;
use App\Entity\Tracking;
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
            if ($tracking->getType() === Tracking::TYPE_CLICK) {
                $clicks += count($tracking->getData());
                continue;
            }
        }
        foreach ($session->getTrackings() as $tracking) {
            if ($tracking->getType() === Tracking::TYPE_SCROLL) {
                $scroling = [];
                foreach ($tracking->getData() as $scrollData) {
                    $scroling[] =  $scrollData['Y'] ?? $scrollData['y'];
                }
                if (!empty($scroling)) {
                    $scroll = max($scroling);
                }
            }
        }

        //Template of the session data
        $sessionsTemplate = $this->sessionRepository->findBy(['template' => $session->getTemplate()]);
        $sessionTemplateTimes = [];
        $sessionTemplateSuccess = [];
        $templateScroll = 0;
        $templateClicks = 0;
        foreach ($sessionsTemplate as $templateSession) {
            if ($templateSession->getDateEnd() === null || $templateSession->getDateStart() === null) {
                continue;
            } else {

                $sessionTemplateTimes[] = $templateSession->getDateEnd()->getTimestamp() - $templateSession->getDateStart()->getTimestamp();
                $sessionTemplateSuccess[] = $templateSession->getIsSuccess();
                foreach ($templateSession->getTrackings() as $tracking) {
                    if ($tracking->getType() === Tracking::TYPE_CLICK) {
                        $templateClicks += count($tracking->getData());
                        break;
                    }
                }
                foreach ($templateSession->getTrackings() as $tracking) {
                    if ($tracking->getType() === Tracking::TYPE_SCROLL) {
                        $scroling = [];
                        foreach ($tracking->getData() as $scrollData) {
                            $scroling[] =  $scrollData['Y'] ?? $scrollData['y'];
                        }
                        if (!empty($scroling)) {
                            $templateScroll = max($scroling);
                        }
                        break;
                    }
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
            if ($personaSession->getDateEnd() === null || $personaSession->getDateStart() === null) {
                continue;
            } else {

                $sessionPersonaTimes[] = $personaSession->getDateEnd()->getTimestamp() - $personaSession->getDateStart()->getTimestamp();
                $sessionPersonaSuccess[] = $personaSession->getIsSuccess();
                foreach ($personaSession->getTrackings() as $tracking) {
                    if ($tracking->getType() === Tracking::TYPE_CLICK) {
                        $personaClicks += count($tracking->getData());
                        break;
                    }
                }
                foreach ($personaSession->getTrackings() as $tracking) {
                    if ($tracking->getType() === Tracking::TYPE_SCROLL) {
                        $scroling = [];
                        foreach ($tracking->getData() as $scrollData) {
                            $scroling[] =  $scrollData['Y'] ?? $scrollData['y'];
                        }
                        $personaScroll = max($scroling);
                        break;
                    }
                }
            }
        }

        $sessionTime = ($session->getDateStart() !== null || $session->getDateEnd() !== null) ? $session->getDateEnd()->getTimestamp() - $session->getDateStart()->getTimestamp() : 'N/A';
        $sessionDate = ($session->getDateStart() !== null || $session->getDateEnd() !== null)  ? $session->getDateStart()->format('d/m/Y') : 'N/A';

        $template = [
            'name' => $session->getTemplate()->getName(),
            'count' => count($sessionsTemplate),
            'avgTime' => count($sessionsTemplate) > 0 ? array_sum($sessionTemplateTimes) / count($sessionsTemplate) : 0,
            'maxTime' => count($sessionTemplateTimes) > 0 ? max($sessionTemplateTimes) : 0,
            'minTime' => count($sessionTemplateTimes) > 0 ? min($sessionTemplateTimes) : 0,
            'successRate' => count($sessionsTemplate) > 0 ? array_sum($sessionTemplateSuccess) / count($sessionsTemplate) : 0,
            'clicks' => $templateClicks,
            'graph' => [
                count($sessionsTemplate) > 0 ? $templateClicks / count($sessionsTemplate) : 0,
                count($sessionsTemplate) > 0 ? array_sum($sessionTemplateTimes) / count($sessionsTemplate) : 0,
                $templateScroll / ($session->getPageHeight() ?? 5080) * 100
            ],
        ];

        $persona = [
            'name' => $session->getPersona()->getName(),
            'avgTime' => count($sessionsPersona)  > 0 ? array_sum($sessionPersonaTimes) / count($sessionsPersona) : 0,
            'maxTime' => count($sessionPersonaTimes) > 0 ? max($sessionPersonaTimes) : 0,
            'minTime' => count($sessionPersonaTimes) > 0 ? min($sessionPersonaTimes) : 0,
            'successRate' => count($sessionsPersona) > 0 ? array_sum($sessionPersonaSuccess) / count($sessionsPersona) : 0,
            'count' => count($sessionsPersona),
            'graph' => [
                count($sessionsPersona)  > 0 ? $personaClicks / count($sessionsPersona) : 0,
                count($sessionsPersona)  > 0 ? array_sum($sessionPersonaTimes) / count($sessionsPersona) : 0,
                $personaScroll / ($session->getPageHeight() ?? 5080) * 100
            ],
        ];


        //Global data array
        $data = [
            'sessionDate' => $sessionDate,
            'sessionTime' => $sessionTime,
            'sessionName' => $session->getTitle(),
            'isSuccess' => $session->getIsSuccess(),
            'sessionName' => $session->getTitle(),
            'graph'  => [
                $clicks,
                $sessionTime,
                $scroll / ($session->getPageHeight() ?? 5080) * 100
            ],
            'template' => $template,
            'persona' => $persona,
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
