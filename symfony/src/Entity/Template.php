<?php

namespace App\Entity;

use App\Repository\TemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateRepository::class)]
class Template
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\OneToMany(mappedBy: 'template', targetEntity: session::class)]
    private Collection $session;

    public function __construct()
    {
        $this->session = new ArrayCollection();
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

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return Collection<int, session>
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(session $session): static
    {
        if (!$this->session->contains($session)) {
            $this->session->add($session);
            $session->setTemplate($this);
        }

        return $this;
    }

    public function removeSession(session $session): static
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getTemplate() === $this) {
                $session->setTemplate(null);
            }
        }

        return $this;
    }
}