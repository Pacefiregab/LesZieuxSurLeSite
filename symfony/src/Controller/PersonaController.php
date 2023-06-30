<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use mysql_xdevapi\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/persona')]
class PersonaController extends AbstractController
{
    private PersonaRepository $personaRepository;

    protected FormFactoryInterface $formFactory;

    public function __construct(
        PersonaRepository $personaRepository,
        FormFactoryInterface $formFactory
    ) {
        $this->personaRepository = $personaRepository;
        $this->formFactory = $formFactory;
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

    #[Route('/api/{id}', name: 'api_index_persona', methods: ['GET'])]
    public function apiIndex(Persona $persona): JsonResponse
    {
        $graph = [
            'interface1' => 30,
            'interface2' => 20,
            'interface3' => 50,
        ];
        //detail dois avoir la route personas_show
        $data = [
            'nombreSessions' => [
                'donnee' => rand(0, 100),
                'diff'=> rand(-100, 100),
            ],
            'tauxReussite' => [
                'donnee' => rand(0, 100),
                'diff'=> rand(-100, 100),
            ],
            'nombreInterfaces' => [
                'donnee' => rand(0, 100),
                'diff'=> rand(-100, 100),
            ],
            'graph' => $graph,
            'detail' => $this->generateUrl('personas_show_sessions', ['id' => $persona->getId()]),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
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
