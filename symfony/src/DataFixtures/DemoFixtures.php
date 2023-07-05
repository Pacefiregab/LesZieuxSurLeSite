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
        $persona = new Persona();
        $persona->setName('Acheter 4 tickets +');
        $persona->setLibelle(Persona::FLAGS_LIBELLE[Persona::FLAG_PREMIUM_TICKETS]);
        $persona->setDuration(120);
        $persona->setFlag(Persona::FLAG_PREMIUM_TICKETS);
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
    }

    public function trackingFixtures(ObjectManager $manager): void
    {
    }
}
