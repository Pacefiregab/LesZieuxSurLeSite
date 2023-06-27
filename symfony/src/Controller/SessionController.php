<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function delete(Request $request, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $this->sessionRepository->remove($session);
        }

        return $this->redirectToRoute('sessions_index');
    }

    #[Route('/{id}', name: 'templates_show', methods: 'GET')]
    public function show(Session $session): Response
    {
        return $this->render('sessions/show.html.twig', [
            'session' => $session,
        ]);
    }
}
