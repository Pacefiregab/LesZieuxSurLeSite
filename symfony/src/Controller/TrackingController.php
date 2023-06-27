<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Form\TrackingType;
use App\Repository\TrackingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trackings')]
class TrackingController extends AbstractController
{
    private TrackingRepository $trackingRepository;

    public function __construct(TrackingRepository $trackingRepository)
    {
        $this->trackingRepository = $trackingRepository;
    }

    #[Route('/', name:'trackings', methods:'GET')]
    public function index(): Response
    {
        $trackings = $this->trackingRepository->findAll();

        return $this->render('trackings/index.html.twig', [
            'trackings' => $trackings,
        ]);
    }

    #[Route('/{id}/create', name:'trackings_create', methods:['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $tracking = new Tracking();
        $form = $this->createForm(TrackingType::class, $tracking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->trackingRepository->save($tracking);

            return $this->redirectToRoute('trackings_index');
        }

        return $this->render('trackings/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name:'trackings_edit', methods:['GET', 'POST'])]
    public function edit(Request $request, Tracking $tracking): Response
    {
        $form = $this->createForm(TrackingType::class, $tracking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->trackingRepository->save($tracking);

            return $this->redirectToRoute('trackings_index');
        }

        return $this->render('trackings/edit.html.twig', [
            'tracking' => $tracking,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name:'trackings_delete', methods:'DELETE')]
    public function delete(Request $request, Tracking $tracking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tracking->getId(), $request->request->get('_token'))) {
            $this->trackingRepository->remove($tracking);
        }

        return $this->redirectToRoute('trackings_index');
    }

    #[Route('/{id}', name:'trackings_show', methods:'GET')]
    public function show(Request $request, Tracking $tracking): Response
    {
        return $this->render('trackings/show.html.twig', [
            'tracking' => $tracking,
        ]);
    }
}
