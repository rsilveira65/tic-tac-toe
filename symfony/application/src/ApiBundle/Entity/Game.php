<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Game
 *
 * @ORM\Table(name="games")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    private $modified;

    /**
     * @Assert\NotBlank()
     *
     * Many Games have One PlayerOne
     *
     * @ORM\ManyToOne(targetEntity="Player")
     * @ORM\JoinColumn(name="player_one_id", referencedColumnName="id")
     */
    private $playerOne;

    /**
     * Many Games have One PlayerTwo
     *
     * @ORM\ManyToOne(targetEntity="Player")
     * @ORM\JoinColumn(name="player_two_id", referencedColumnName="id", nullable=true)
     */
    private $playerTwo;

    /**
     * @var Board
     *
     * One Game has One Board
     *
     * @ORM\OneToOne(targetEntity="Board", mappedBy="game")
     */
    private $board;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Game
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param string|\DateTime $created
     *
     * @return Game
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param string|\DateTime $modified
     *
     * @return Game
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set playerOne
     *
     * @param Player $playerOne
     *
     * @return Game
     */
    public function setPlayerOne($playerOne)
    {
        $this->playerOne = $playerOne;

        return $this;
    }

    /**
     * Get playerOne
     *
     * @return Player
     */
    public function getPlayerOne()
    {
        return $this->playerOne;
    }

    /**
     * Set playerTwo
     *
     * @param Player $playerTwo
     *
     * @return Game
     */
    public function setPlayerTwo($playerTwo)
    {
        $this->playerTwo = $playerTwo;

        return $this;
    }

    /**
     * Get playerTwo
     *
     * @return Player
     */
    public function getPlayerTwo()
    {
        return $this->playerTwo;
    }

    /**
     * Set board
     *
     * @param Board $board
     *
     * @return Game
     */
    public function setBoard($board)
    {
        $this->board = $board;

        return $this;
    }

    /**
     * Get board
     *
     * @return Board
     */
    public function getBoard()
    {
        return $this->board;
    }
}

