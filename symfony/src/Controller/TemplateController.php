<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Entity\Template;
use App\Form\TemplateType;
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

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    #[Route('/', name:'templates_index', methods:'GET')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $templates = $entityManager->getRepository(Template::class)->findAll();

        return $this->render('template/index.html.twig', [
            'templates' => $templates,
        ]);
    }

    #[Route('/create', name:'templates_create', methods:['POST'])]
    public function create(Request $request): Response
    {
        $template = new Template();
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->templateRepository->save($template);

            return $this->redirectToRoute('templates_index');
        }

        return $this->render('templates/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name:'templates_edit', methods:['GET', 'POST'])]
    public function edit(Request $request, Template $template): Response
    {
        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->templateRepository->save($template);

            return $this->redirectToRoute('templates_index');
        }

        return $this->render('templates/edit.html.twig', [
            'template' => $template,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name:'templates_delete', methods:'DELETE')]
    public function delete(Request $request, Template $template): Response
    {
        if ($this->isCsrfTokenValid('delete' . $template->getId(), $request->request->get('_token'))) {
            $this->templateRepository->remove($template);
        }

        return $this->redirectToRoute('templates_index');
    }

    #[Route('/show/{id}', name:'templates_show', methods:'GET')]
    public function show(Template $template): Response
    {
        return $this->render('templates/show.html.twig', [
            'template' => $template,
        ]);
    }

    #[Route('/form')]
    #[Route('/form/{id}', name: 'template_form_get', methods: ['GET'])]
    public function form(?Template $template): JsonResponse {
        $template = $template ?? new Template();
        $html = $this->renderView('template/form.html.twig', [
            'template' => $template,
        ]);

        return new JsonResponse([
            'html' => $html,
        ]);
    }
}
