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
        $this->personaFixtures($manager);
        $this->templateFixtures($manager);
        $this->sessionFixtures($manager);
        $this->trackingFixtures($manager);

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
                "whiteColor" => $this->faker->colorName(),
                "darkColor" => $this->faker->colorName(),
                "primaryColor" => $this->faker->colorName(),
                "secondaryColor" => $this->faker->colorName()
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

            $this->trackingRepository->save($tracking1, true);
            $this->trackingRepository->save($tracking2, true);
            $this->trackingRepository->save($tracking3, true);
        }
    }
}
