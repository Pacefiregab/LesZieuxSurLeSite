<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/personas')]
class PersonaController extends AbstractController
{
    private PersonaRepository $personaRepository;

    public function __construct(PersonaRepository $personaRepository)
    {
        $this->personaRepository = $personaRepository;
    }


    #[Route('/', name:'personas_index', methods:'GET')]
    public function index(): Response
    {
        $personas = $this->personaRepository->findAll();

        return $this->render('personas/index.html.twig', [
            'personas' => $personas,
        ]);
    }


    #[Route('/create', name:'personas_create', methods:['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $persona = new Persona();
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personaRepository->save($persona);

            return $this->redirectToRoute('personas_index');
        }

        return $this->render('personas/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name:'personas_edit', methods:['GET', 'POST'])]
    public function edit(Request $request, Persona $persona): Response
    {
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personaRepository->save($persona);

            return $this->redirectToRoute('personas_index');
        }

        return $this->render('personas/edit.html.twig', [
            'persona' => $persona,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/', name:'personas_delete', methods:'DELETE')]
    public function delete(Request $request, Persona $persona): Response
    {
        if ($this->isCsrfTokenValid('delete'.$persona->getId(), $request->request->get('_token'))) {
            $this->personaRepository->remove($persona);
        }

        return $this->redirectToRoute('personas_index');
    }

    #[Route('/{id}', name:'personas_show', methods:'GET')]
    public function show(Persona $persona): Response
    {
        return $this->render('persona/show.html.twig', [
            'persona' => $persona,
        ]);
    }
}
