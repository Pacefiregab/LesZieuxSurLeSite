<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
class Persona
{
    public const FLAGS_LIBELLE = [
        self::FLAG_YT_GILDOR => 'Youtube de Gildor',
        self::FLAG_YT_JPFROMAGE => 'Youtube de Jean Pierre Fromage',
        self::FLAG_YT_JPLACOSTE => 'Youtube de Jean Pascal Lacoste',
        self::FLAG_CONTACT => 'Soumetre le formulaire de contact',
        self::FLAG_TWITTER => 'Twitter',
        self::FLAG_INSTAGRAM => 'Instagram',
        self::FLAG_FREESYLE_ARTIST => 'Artiste Performant lors des Freestyles',
    ];

    public const FLAGS = [
        self::FLAG_YT_GILDOR,
        self::FLAG_YT_JPFROMAGE,
        self::FLAG_YT_JPLACOSTE,
        self::FLAG_CONTACT,
        self::FLAG_TWITTER,
        self::FLAG_INSTAGRAM,
        self::FLAG_FREESYLE_ARTIST
    ];

    public const FLAG_YT_GILDOR = 'gdYt';
    public const FLAG_YT_JPFROMAGE = 'jpfYt';
    public const FLAG_YT_JPLACOSTE = 'jplYt';
    public const FLAG_CONTACT = 'contact';
    public const FLAG_TWITTER = 'twitter';
    public const FLAG_INSTAGRAM = 'instagram';
    public const FLAG_FREESYLE_ARTIST = 'freestyle_artist';



    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $flag = null;

    #[ORM\OneToMany(mappedBy: 'persona', targetEntity: Session::class, orphanRemoval: true)]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): static
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setPersona($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getPersona() === $this) {
                $session->setPersona(null);
            }
        }

        return $this;
    }
}
