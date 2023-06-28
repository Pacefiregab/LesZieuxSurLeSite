<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/personas')]
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


    #[Route('/', name: 'personas_index', methods: 'GET')]
    public function index(): Response
    {
        $personas = $this->personaRepository->findAll();

        return $this->render('persona/index.html.twig', [
            'personas' => $personas,
        ]);
    }

    #[Route('/create', name: 'personas_create_post', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        $data = $request->request->all();

        $form = $this->formFactory->create(PersonaType::class, new Persona());
        $form->submit($data);


        if (!$form->isValid()) {
            return Response::HTTP_BAD_REQUEST;
        }

        $persona = $form->getData();
        $this->personaRepository->save($persona, true);

        return $this->redirectToRoute('personas_index');
    }


    #[Route('/{id}/edit', name: 'personas_edit', methods: ['GET', 'POST'])]
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


    #[Route('/{id}', name: 'personas_delete', methods: 'DELETE')]
    public function delete(Request $request, Persona $persona): Response
    {
        $this->personaRepository->remove($persona, true);

        return $this->redirectToRoute('personas_index');
    }

    #[Route('/{id}', name: 'personas_show', methods: 'GET')]
    public function show(Persona $persona): Response
    {
        return $this->render('persona/show.html.twig', [
            'persona' => $persona,
        ]);
    }
}
