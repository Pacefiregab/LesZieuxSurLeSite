<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Tracking;
use App\Form\TrackingType;
use App\Repository\TrackingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trackings')]
class TrackingController extends AbstractController
{
    private TrackingRepository $trackingRepository;

    private FormFactoryInterface $formFactory;

    public function __construct(TrackingRepository $trackingRepository, FormFactoryInterface $formFactory)
    {
        $this->trackingRepository = $trackingRepository;
        $this->formFactory = $formFactory;
    }

    #[Route('/', name: 'trackings', methods: 'GET')]
    public function index(): Response
    {
        $trackings = $this->trackingRepository->findAll();

        return $this->render('trackings/index.html.twig', [
            'trackings' => $trackings,
        ]);
    }

    #[Route('/create', name: 'trackings_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = $request->request->all();
        $session = $entityManager->getRepository(Session::class)->find($data['session_id']);

        //traitement des données pour l'oeil
        $eye = ["type" => Tracking::TYPE_EYE,
            "data" => $data['eyeRecord'],
            "session" => $session,
        ];

        $form = $this->formFactory->create(TrackingType::class, new Tracking());
        $form->submit($eye);

        /*
        if (!$form->isValid()) {
            dd($form->getErrors());
            return new Response('formulaire invalide : ' . $form->getErrors(), Response::HTTP_BAD_REQUEST);
        }*/

        $tracking = $form->getData();
        $this->trackingRepository->save($tracking, true);

        //traitement des données le scroll
        $scroll = [
            "type" => Tracking::TYPE_SCROLL,
            "data" => $data['scrollRecord'],
            "session" => $session,
        ];

        $form = $this->formFactory->create(TrackingType::class, new Tracking());
        $form->submit($scroll);

        /*
        if (!$form->isValid()) {
            dd($form->getErrors());
            return new Response('formulaire invalide : ' . $form->getErrors(), Response::HTTP_BAD_REQUEST);
        }*/

        $tracking = $form->getData();
        dump($form);
        $this->trackingRepository->save($tracking, true);

        //traitement des données pour le click
        $click = ["type" => Tracking::TYPE_CLICK,
            "data" => $data['clickRecord'],
            "session" => $session,
        ];
        $click = json_encode($click);

        $form = $this->formFactory->create(TrackingType::class, new Tracking());
        $form->submit($click);

        /*
        if (!$form->isValid()) {
            dd($form->getErrors());
            return new Response('formulaire invalide : ' . $form->getErrors(), Response::HTTP_BAD_REQUEST);
        }*/

        $tracking = $form->getData();
        $this->trackingRepository->save($tracking, true);

        return $this->redirectToRoute('traking_index');
    }

    #[Route('/{id}/edit', name: 'trackings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tracking $tracking): Response
    {
        $data = $request->request->all();

        $form = $this->formFactory->create(TrackingType::class, $tracking);
        $form->submit($data);


        if (!$form->isValid()) {
            return Response::HTTP_BAD_REQUEST;
        }

        $tracking = $form->getData();
        $this->trackingRepository->save($tracking, true);

        return $this->redirectToRoute('traking_index');
    }

    #[Route('/{id}', name: 'trackings_delete', methods: 'DELETE')]
    public function delete(Request $request, Tracking $tracking): Response
    {
        $this->trackingRepository->remove($tracking);
        return $this->redirectToRoute('trackings_index');
    }

    #[Route('/{id}', name: 'trackings_show', methods: 'GET')]
    public function show(Request $request, Tracking $tracking): Response
    {
        return $this->render('trackings/show.html.twig', [
            'tracking' => $tracking,
        ]);
    }
}
