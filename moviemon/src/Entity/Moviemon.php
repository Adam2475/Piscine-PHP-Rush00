<?php

namespace App\Entity;

use App\Repository\MoviemonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviemonRepository::class)]
class Moviemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $health = null;

    #[ORM\Column]
    private ?int $strength = null;

    #[ORM\Column (type: 'string', nullable: false)]
    private ?string $url_poster = null;

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

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): static
    {
        $this->health = $health;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): static
    {
        $this->strength = $strength;

        return $this;
    }

    public function getUrlPoster(): ?string
    {
        return $this->url_poster;
    }

    public function setUrlPoster(string $url_poster): static
    {
        $this->url_poster = $url_poster;

        return $this;
    }
}
