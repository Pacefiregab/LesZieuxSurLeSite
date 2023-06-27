<?php

namespace App\Controller;

use App\Entity\Persona;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        {
            //récuperer tous les personas
            $personas = $entityManager->getRepository(Persona::class)->findAll();
            //si personas et vide on crée un crée un faux objet persona
            if (empty($personas)) {
                for ($i = 0; $i < 3; $i++) {
                    $persona = new Persona();
                    $persona->setName('Aucun persona'.$i);
                    $persona->setLibelle('Aucun persona');
                    $personas[] = $persona;
                }
            }


            return $this->render('dashboard/index.html.twig', [
                'personas' => $personas,
            ]);
        }
    }
}
