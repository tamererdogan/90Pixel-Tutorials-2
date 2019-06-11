<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FootballMatchRepository")
 * @ORM\EntityListeners({"App\EventListener\MatchListener"})
 */
class FootballMatch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="footballMatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $home;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="footballMatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $away;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $homeGoals;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $awayGoals;

    /**
     * @ORM\Column(type="boolean")
     */
    private $state;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $result;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $week;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHome(): ?Team
    {
        return $this->home;
    }

    public function setHome(?Team $home): self
    {
        $this->home = $home;

        return $this;
    }

    public function getAway(): ?Team
    {
        return $this->away;
    }

    public function setAway(?Team $away): self
    {
        $this->away = $away;

        return $this;
    }

    public function getHomeGoals(): ?int
    {
        return $this->homeGoals;
    }

    public function setHomeGoals(?int $homeGoals): self
    {
        $this->homeGoals = $homeGoals;

        return $this;
    }

    public function getAwayGoals(): ?int
    {
        return $this->awayGoals;
    }

    public function setAwayGoals(?int $awayGoals): self
    {
        $this->awayGoals = $awayGoals;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(?int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(?int $week): self
    {
        $this->week = $week;

        return $this;
    }
}
