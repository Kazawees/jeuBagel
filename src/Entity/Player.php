<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;




#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: Gamer::class, orphanRemoval: true, cascade: ["persist"])]
    private $gamers;

    public function __construct()
    {
        $this->gamers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Gamer>
     */
    public function getGamers(): Collection
    {
        return $this->gamers;
    }

    public function addGamer(Gamer $gamer): self
    {
        if (!$this->gamers->contains($gamer)) {
            $this->gamers[] = $gamer;
            $gamer->setPlayer($this);
        }

        return $this;
    }

    public function removeGamer(Gamer $gamer): self
    {
        if ($this->gamers->removeElement($gamer)) {
            // set the owning side to null (unless already changed)
            if ($gamer->getPlayer() === $this) {
                $gamer->setPlayer(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->name; // Remplacer champ par une propriété "string" de l'entité
    }
    
}
