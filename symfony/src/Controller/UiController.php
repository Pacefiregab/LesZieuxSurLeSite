<?php

namespace App\Controller;


use App\Entity\Persona;
use App\Entity\Session;
use App\Entity\Template;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/ui')]
class UiController extends AbstractController
{
    #[Route(['/{session}','/'] ,name: 'app_ui')]
    public function index(?Session $session, EntityManagerInterface $entityManager): Response {
        if (!$session) {
            $session = new Session();
            $persona = $entityManager->getRepository(Persona::class)->findOneBy([]);
            $session->setTemplate(new Template());
            $session->setPersona($persona);

            $entityManager->persist($session);
            $entityManager->flush();
        }

        return $this->render('ui/index.html.twig', [
            'data' => $session->getTemplate()?->getData() ?? [],
            'persona' => $session->getPersona(),
            'session' => $session,
        ]);
    }
}
