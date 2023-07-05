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
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
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
        //old fixture call
        //$this->personaFixtures($manager);
        //$this->templateFixtures($manager);
        //$this->sessionFixtures($manager);
        //$this->trackingFixtures($manager);

        //new fixture for the demo
        $this->personaFixturesDemo($manager);
        $this->templateFixturesDemo($manager);

        $manager->flush();
    }

    //persona
    public function personaFixtures(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $persona = new Persona();
            $persona->setName($this->faker->name());
            $persona->setFlag($this->faker->randomElement(Persona::FLAGS));
            $persona->setLibelle(Persona::FLAGS_LIBELLE[$persona->getFlag()]);
            $persona->setDuration($this->faker->numberBetween(0, 120));
            $this->personaRepository->save($persona, true);
        }
    }

    //template
    public function templateFixtures(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $template = new Template();
            $template->setName("session n'" . $i);
            $template->setData(array(
                "reverseRow" => $this->faker->boolean(),
                "hideHeader" => $this->faker->boolean(),
                "stickyHeader" => false,
                "specialButtonForTicket" => $this->faker->boolean(),
                "contactMapFirst" => $this->faker->boolean(),
                "changeCheckBoxSelect" => $this->faker->boolean(),
                "whiteColor" => $this->faker->hexColor(),
                "darkColor" => $this->faker->hexColor(),
                "primaryColor" => $this->faker->hexColor(),
                "secondaryColor" => $this->faker->hexColor()
            ));
            $this->templateRepository->save($template, true);
        }
    }

    //session
    public function sessionFixtures(ObjectManager $manager): void
    {
        //$faker->dateTimeBetween(new DateTime(), '+2 minutes');

        $templates = $this->templateRepository->findAll();
        $personas = $this->personaRepository->findAll();


        for ($i = 0; $i < 10; $i++) {
            $session = new Session();
            $session->setTemplate($this->faker->randomElement($templates));
            $session->setDateStart(new DateTime());
            $session->setDateEnd($this->faker->dateTimeBetween($session->getDateStart(), '+2 minutes'));
            $session->setTitle("session n'" . $i);
            $session->setPersona($this->faker->randomElement($personas));
            $session->setIsSuccess($this->faker->boolean());
            $this->sessionRepository->save($session, true);
        }
    }

    //tracking
    public function trackingFixtures(ObjectManager $manager): void
    {
        $sessions = $this->sessionRepository->findAll();
        for ($i = 0; $i < 10; $i++) {
            $tracking1 = new Tracking();
            $tracking2 = new Tracking();
            $tracking3 = new Tracking();
            $tracking4 = new Tracking();

            $tracking1->setSession($sessions[$i]);
            $tracking1->setType(Tracking::TYPE_EYE);

            $X1 = ($this->faker->numberBetween(0, 1920));
            $Y1 = ($this->faker->numberBetween(0, 1080));

            $data1 = [];
            for ($x = 0; $x < 100; $x++) {
                $data1[] = array(
                    "x" => $this->faker->numberBetween($X1 - 10, $X1 + 10),
                    "y" => $this->faker->numberBetween($Y1 - 10, $Y1 + 10),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            for ($x = 0; $x < 900; $x++) {
                $data1[] = array(
                    "x" => $this->faker->numberBetween(0, 1920),
                    "y" => $this->faker->numberBetween(0, 1080),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            $tracking1->setData($data1);

            $tracking2->setSession($tracking1->getSession());
            $tracking2->setType(Tracking::TYPE_CLICK);

            $X2 = ($this->faker->numberBetween(0, 1920));
            $Y2 = ($this->faker->numberBetween(0, 1080));

            $data2 = [];
            for ($x = 0; $x < 10; $x++) {
                $data2[] = array(
                    "x" => $this->faker->numberBetween($X2 - 10, $X2 + 10),
                    "y" => $this->faker->numberBetween($Y2 - 10, $Y2 + 10),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            for ($x = 0; $x < 90; $x++) {
                $data2[] = array(
                    "x" => $this->faker->numberBetween(0, 1920),
                    "y" => $this->faker->numberBetween(0, 1080),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            $tracking2->setData($data2);

            $tracking3->setSession($tracking1->getSession());
            $tracking3->setType(Tracking::TYPE_SCROLL);
            $Y3 = ($this->faker->numberBetween(0, 1080));
            $data3 = [];
            for ($x = 0; $x < 50; $x++) {
                $data3[] = array(
                    "x" => 0,
                    "y" => $this->faker->numberBetween($Y3 - 10, $Y3 + 10),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            for ($x = 0; $x < 450; $x++) {
                $data3[] = array(
                    "x" => 0,
                    "y" => $this->faker->numberBetween(0, 1080),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            $tracking3->setData($data3);

            $tracking4->setSession($tracking1->getSession());
            $tracking4->setType(Tracking::TYPE_MOUSE);
            $Y3 = ($this->faker->numberBetween(0, 1080));
            $data4 = [];
            for ($x = 0; $x < 50; $x++) {
                $data4[] = array(
                    "x" => 0,
                    "y" => $this->faker->numberBetween($Y3 - 10, $Y3 + 10),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            for ($x = 0; $x < 450; $x++) {
                $data4[] = array(
                    "x" => 0,
                    "y" => $this->faker->numberBetween(0, 1080),
                    "time" => $this->faker->numberBetween(0, 100000)
                );
            }
            $tracking4->setData($data4);

            $this->trackingRepository->save($tracking1, true);
            $this->trackingRepository->save($tracking2, true);
            $this->trackingRepository->save($tracking3, true);
            $this->trackingRepository->save($tracking4, true);
        }
    }

    public function personaFixturesDemo(ObjectManager $manager): void
    {
        //first persona
        $persona = new Persona();
        $persona->setName(Persona::FLAGS_LIBELLE[Persona::FLAG_YT_GILDOR]);
        $persona->setFlag(Persona::FLAG_YT_GILDOR);
        $persona->setLibelle("Recherche de la chaîne youtube de l'artiste Gildor");
        $persona->setDuration(60);
        $this->personaRepository->save($persona, true);

        //second persona
        $persona = new Persona();
        $persona->setName(Persona::FLAGS_LIBELLE[Persona::FLAG_FREESYLE_ARTIST]);
        $persona->setFlag(Persona::FLAG_FREESYLE_ARTIST);
        $persona->setLibelle("Recherche l'artiste performant le freestyle dans l'agenda");
        $persona->setDuration(120);
        $this->personaRepository->save($persona, true);

        //third persona
        $persona = new Persona();
        $persona->setName(Persona::FLAGS_LIBELLE[Persona::FLAG_TWITTER]);
        $persona->setFlag(Persona::FLAG_TWITTER);
        $persona->setLibelle("Recherche le lien vers le compte twitter");
        $persona->setDuration(30);
        $this->personaRepository->save($persona, true);
    }

    public function templateFixturesDemo(ObjectManager $manager): void
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
}
