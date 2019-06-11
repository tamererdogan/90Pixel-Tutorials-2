<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoreBoardRepository")
 * @ORM\EntityListeners({"App\EventListener\ScoreBoardListener"})
 */
class ScoreBoard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Team", inversedBy="scoreBoard", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rank;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $playedMatch;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $win;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lose;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $draw;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $homeGoals;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $awayGoals;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $average;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $point;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getPlayedMatch(): ?int
    {
        return $this->playedMatch;
    }

    public function setPlayedMatch(?int $playedMatch): self
    {
        $this->playedMatch = $playedMatch;

        return $this;
    }

    public function getWin(): ?int
    {
        return $this->win;
    }

    public function setWin(?int $win): self
    {
        $this->win = $win;

        return $this;
    }

    public function getLose(): ?int
    {
        return $this->lose;
    }

    public function setLose(?int $lose): self
    {
        $this->lose = $lose;

        return $this;
    }

    public function getDraw(): ?int
    {
        return $this->draw;
    }

    public function setDraw(?int $draw): self
    {
        $this->draw = $draw;

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

    public function getAverage(): ?int
    {
        return $this->average;
    }

    public function setAverage(?int $average): self
    {
        $this->average = $average;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(?int $point): self
    {
        $this->point = $point;

        return $this;
    }
}
