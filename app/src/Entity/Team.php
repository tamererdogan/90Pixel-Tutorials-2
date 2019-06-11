<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @ORM\EntityListeners({"App\EventListener\TeamListener"})
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ScoreBoard", mappedBy="team", cascade={"persist", "remove"})
     */
    private $scoreBoard;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FootballMatch", mappedBy="home", orphanRemoval=true)
     */
    private $footballMatches;

    public function __construct()
    {
        $this->footballMatches = new ArrayCollection();
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

    public function getScoreBoard(): ?ScoreBoard
    {
        return $this->scoreBoard;
    }

    public function setScoreBoard(ScoreBoard $scoreBoard): self
    {
        $this->scoreBoard = $scoreBoard;

        // set the owning side of the relation if necessary
        if ($this !== $scoreBoard->getTeam()) {
            $scoreBoard->setTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection|FootballMatch[]
     */
    public function getFootballMatches(): Collection
    {
        return $this->footballMatches;
    }

    public function addFootballMatch(FootballMatch $footballMatch): self
    {
        if (!$this->footballMatches->contains($footballMatch)) {
            $this->footballMatches[] = $footballMatch;
            $footballMatch->setHome($this);
        }

        return $this;
    }

    public function removeFootballMatch(FootballMatch $footballMatch): self
    {
        if ($this->footballMatches->contains($footballMatch)) {
            $this->footballMatches->removeElement($footballMatch);
            // set the owning side to null (unless already changed)
            if ($footballMatch->getHome() === $this) {
                $footballMatch->setHome(null);
            }
        }

        return $this;
    }
}
