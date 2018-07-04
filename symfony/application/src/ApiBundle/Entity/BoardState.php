<?php

namespace ApiBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Round
 *
 * @ORM\Table(name="board_states")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\BoardStateRepository")
 */
class BoardState
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Groups({"ApiGameRoundResponse"})
     * @var \DateTime
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @Groups({"ApiGameRoundResponse"})
     * @var \DateTime
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    private $modified;

    /**
     * @Assert\NotBlank()
     *
     * Many BoardStates have One Board
     *
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="boardStates")
     * @ORM\JoinColumn(name="board_id", referencedColumnName="id")
     */
    private $board;

    /**
     * @var string
     *
     * @ORM\Column(name="x0", type="string", length=255)
     */
    private $x0;

    /**
     * @var string
     *
     * @ORM\Column(name="x1", type="string", length=255)
     */
    private $x1;

    /**
     * @var string
     *
     * @ORM\Column(name="x2", type="string", length=255)
     */
    private $x2;

    /**
     * Round constructor.
     */
    public function __construct()
    {
        $this->roundQuestions = new ArrayCollection();
    }

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
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string|\DateTime $created
     * @return BoardState
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
     * @param string|\DateTime $modified
     * @return BoardState
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        return $this;
    }

    /**
     * Set board
     *
     * @param Board $board
     *
     * @return BoardState
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

    /**
     * Set X0
     *
     * @param string $x0
     *
     * @return BoardState
     */
    public function setX0($x0)
    {
        $this->x0 = $x0;

        return $this;
    }

    /**
     * Get X0
     *
     * @return string
     */
    public function getX0()
    {
        return $this->x0;
    }

    /**
     * Set X1
     *
     * @param string $x1
     *
     * @return BoardState
     */
    public function setX1($x1)
    {
        $this->x1 = $x1;

        return $this;
    }

    /**
     * Get X1
     *
     * @return string
     */
    public function getX1()
    {
        return $this->x1;
    }

    /**
     * Set X2
     *
     * @param string $x2
     *
     * @return BoardState
     */
    public function setX2($x2)
    {
        $this->x2 = $x2;

        return $this;
    }

    /**
     * Get X2
     *
     * @return string
     */
    public function getX2()
    {
        return $this->x2;
    }
}

