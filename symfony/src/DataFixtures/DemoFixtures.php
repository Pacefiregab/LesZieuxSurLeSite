<?php

namespace App\DataFixtures;

use App\Entity\Persona;
use App\Entity\Session;
use App\Entity\Template;
use App\Entity\Tracking;
use App\Repository\PersonaRepository;
use App\Repository\SessionRepository;
use App\Repository\TemplateRepository;
use App\Repository\TrackingRepository;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\ar_EG\Person;

class DemoFixtures extends Fixture implements FixtureGroupInterface
{

    private Generator $faker;

    public PersonaRepository $personaRepository;

    public TemplateRepository $templateRepository;

    public TrackingRepository $trackingRepository;

    public SessionRepository $sessionRepository;

    public function __construct(
        PersonaRepository $personaRepository,
        TemplateRepository $templateRepository,
        TrackingRepository $trackingRepository,
        SessionRepository $sessionRepository
    ) {
        $this->personaRepository = $personaRepository;
        $this->templateRepository = $templateRepository;
        $this->trackingRepository = $trackingRepository;
        $this->sessionRepository = $sessionRepository;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->personaFixtures($manager);
        $this->templateFixtures($manager);
        $this->sessionFixtures($manager);
        $this->trackingFixtures($manager);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }


    private function personaFixtures(ObjectManager $manager): void
    {
        //first
        $persona = new Persona();
        $persona->setName('Acheter 4 tickets +');
        $persona->setLibelle("Achete 4 tickets premium");
        $persona->setDuration(120);
        $persona->setFlag(Persona::FLAG_PREMIUM_TICKETS);
        $this->personaRepository->save($persona, true);

        //second persona
        $persona = new Persona();
        $persona->setName(Persona::FLAGS_LIBELLE[Persona::FLAG_YT_GILDOR]);
        $persona->setFlag(Persona::FLAG_YT_GILDOR);
        $persona->setLibelle("Recherche de la chaîne youtube de l'artiste Gildor");
        $persona->setDuration(60);
        $this->personaRepository->save($persona, true);

        //third persona
        $persona = new Persona();
        $persona->setName(Persona::FLAGS_LIBELLE[Persona::FLAG_FREESYLE_ARTIST]);
        $persona->setFlag(Persona::FLAG_FREESYLE_ARTIST);
        $persona->setLibelle("Recherche l'artiste performant le freestyle dans l'agenda");
        $persona->setDuration(120);
        $this->personaRepository->save($persona, true);

        //fourth persona
        $persona = new Persona();
        $persona->setName(Persona::FLAGS_LIBELLE[Persona::FLAG_TWITTER]);
        $persona->setFlag(Persona::FLAG_TWITTER);
        $persona->setLibelle("Recherche le lien vers le compte twitter");
        $persona->setDuration(30);
        $this->personaRepository->save($persona, true);
    }

    public function sessionFixtures(ObjectManager $manager): void
    {
        $template = new Template();
        $template->setName("Template n°1");
        $template->setData(array());
        $this->templateRepository->save($template, true);
    }

    public function templateFixtures(ObjectManager $manager): void
    {
        //first template -> high contrast
        $template = new Template();
        $template->setName("Template haut contraste");
        $template->setData(array(
            "reverseRow" => false,
            "hideHeader" => true,
            "stickyHeader" => false,
            "specialButtonForTicket" => false,
            "contactMapFirst" => true,
            "changeCheckBoxSelect" => true,
            "whiteColor" => "#F33BEE",
            "darkColor" => "#000000",
            "primaryColor" => "#DEFF00",
            "secondaryColor" => "#AAAAAA"
        ));
        $this->templateRepository->save($template, true);


        //second template -> low contrast (gray scale)
        $template = new Template();
        $template->setName("Template bas contraste");
        $template->setData(array(
            "reverseRow" => true,
            "hideHeader" => true,
            "stickyHeader" => false,
            "specialButtonForTicket" => true,
            "contactMapFirst" => true,
            "changeCheckBoxSelect" => false,
            "whiteColor" => "#999999",
            "darkColor" => "#333333",
            "primaryColor" => "#777777",
            "secondaryColor" => "#555555"
        ));
        $this->templateRepository->save($template, true);


        //third template -> medium contrast
        $template = new Template();
        $template->setName("Template contraste modéré");
        $template->setData(array(
            "reverseRow" => false,
            "hideHeader" => true,
            "stickyHeader" => false,
            "specialButtonForTicket" => false,
            "contactMapFirst" => false,
            "changeCheckBoxSelect" => false,
            "whiteColor" => "#990F0F",
            "darkColor" => "#3B591E",
            "primaryColor" => "#E27606",
            "secondaryColor" => "#527B1D"
        ));
        $this->templateRepository->save($template, true);


        //fourth template -> pink hue
        $template = new Template();
        $template->setName("Template de rose");
        $template->setData(array(
            "reverseRow" => true,
            "hideHeader" => false,
            "stickyHeader" => false,
            "specialButtonForTicket" => true,
            "contactMapFirst" => true,
            "changeCheckBoxSelect" => true,
            "whiteColor" => "#8757DF",
            "darkColor" => "#1A28BF",
            "primaryColor" => "#F385FE",
            "secondaryColor" => "#BE6FEE"
        ));
        $this->templateRepository->save($template, true);
    }

    public function trackingFixtures(ObjectManager $manager): void
    {
    }
}
