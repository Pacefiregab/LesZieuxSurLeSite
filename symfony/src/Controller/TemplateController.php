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
use Symfony\Component\Validator\Constraints\Json;

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

            if (!in_array($persona, $personas)) {
                $personas[] = $persona;
                $statistics[$persona] = [
                    'maxTime' => $session->getTime(),
                    'minTime' => $session->getTime(),
                    'totalTime' => $session->getTime(),
                    'sessionCount' => 1,
                    'successCount' => $session->getIsSuccess() ? 1 : 0,
                ];
            } else {
                $statistics[$persona]['maxTime'] = max($statistics[$persona]['maxTime'], $session->getTime());
                $statistics[$persona]['minTime'] = min($statistics[$persona]['minTime'], $session->getTime());
                $statistics[$persona]['totalTime'] += $session->getTime();
                $statistics[$persona]['sessionCount']++;
                $statistics[$persona]['successCount'] += $session->getIsSuccess() ? 1 : 0;
            }
        }
 */


        $template = [
            'id' => $template->getId(),
            'name' => $template->getName(),
            'data' => $template->getData(),
            'personas' => $personas,
        ];
        return new JsonResponse($template);
    }
}
