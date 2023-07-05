<?php

namespace App\Controller;

use App\Entity\Persona;
use DateTime;
use App\Entity\Session;
use App\Entity\Template;
use App\Entity\Tracking;
use App\Form\TrackingType;
use App\Repository\SessionRepository;
use App\Repository\TrackingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trackings')]
class TrackingController extends AbstractController
{
    private TrackingRepository $trackingRepository;

    private SessionRepository $sessionRepository;

    private FormFactoryInterface $formFactory;

    public function __construct(
        TrackingRepository $trackingRepository,
        FormFactoryInterface $formFactory,
        SessionRepository $sessionRepository
    ) {
        $this->trackingRepository = $trackingRepository;
        $this->formFactory = $formFactory;
        $this->sessionRepository = $sessionRepository;
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
        dump($data);
        $sessionId = $data['sessionId'] ?? null;
        $session = $sessionId ? $entityManager->getRepository(Session::class)->find($sessionId) : null;
        if (!$session instanceof Session) {
            $session = (new Session())
                ->setPersona($entityManager->getRepository(Persona::class)->find($data['personaId']))
                ->setTemplate($entityManager->getRepository(Template::class)->find($data['templateId']))
                ->setTitle('Session n°X1');
            $entityManager->persist($session);
        }

        //ajout de date de début + fin
        $session->setDateStart(new DateTime(date("Y-m-d H:i:s", $data['startDate'])));
        $session->setDateEnd(new DateTime(date("Y-m-d H:i:s", $data['endDate'])));
        $session->setIsSuccess($data['isSuccess']);
        $session->setPageHeight($data['windowHeight']);
        $this->sessionRepository->save($session, true);

        //traitement des données eye tracker
        $eyeTracking = new Tracking();
        $eyeTracking->setSession($session)
            ->setType(Tracking::TYPE_EYE)
            ->setData(json_decode($data['eyeRecord']));
        $this->trackingRepository->save($eyeTracking, true);

        //traitement des données le scroll
        $scrollTracking = new Tracking();
        $scrollTracking->setSession($session)
            ->setType(Tracking::TYPE_SCROLL)
            ->setData(json_decode($data['scrollRecord']));
        $this->trackingRepository->save($scrollTracking, true);

        //traitement des données le click
        $clickTracking = new Tracking();
        $clickTracking->setSession($session)
            ->setType(Tracking::TYPE_CLICK)
            ->setData(json_decode($data['clickRecord']));
        $this->trackingRepository->save($clickTracking, true);

        //traitement des données de la souris
        $mouseTracking = new Tracking();
        $mouseTracking->setSession($session)
            ->setType(Tracking::TYPE_MOUSE)
            ->setData(json_decode($data['mouseRecord']));
        $this->trackingRepository->save($mouseTracking, true);

        $entityManager->flush();
        $session->setTitle('Session n°' . $session->getId());
        $entityManager->flush();
        return $this->redirectToRoute('personas_show_sessions', ['id' => $session->getId()]);
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
