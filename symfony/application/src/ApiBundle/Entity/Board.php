<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Board
 *
 * @ORM\Table(name="boards")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\BoardRepository")
 */
class Board
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Game
     *
     * One Board has One Game
     *
     * @ORM\OneToOne(targetEntity="Game", inversedBy="board")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $game;

    /**
     * @var Collection
     * One Board has Many BoardStates
     *
     * @ORM\OneToMany(targetEntity="BoardState", mappedBy="board", cascade={"persist"})
     */
    private $boardStates;

    /**
     * Board constructor.
     */
    public function __construct()
    {
        $this->boardStates = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param Game $game
     * @return Board
     */
    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getBoardStates()
    {
        return $this->boardStates;
    }

    /**
     * @param BoardState $boardState
     */
    public function addBoardState(BoardState $boardState)
    {
        $this->boardStates->add($boardState);
    }
}
