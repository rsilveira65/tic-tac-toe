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
     * @ORM\Column(name="x", type="string", length=255)
     */
    private $x;

    /**
     * @var string
     *
     * @ORM\Column(name="y", type="string", length=255)
     */
    private $y;

    /**
     * @var string
     *
     * @ORM\Column(name="z", type="string", length=255)
     */
    private $z;

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
     * Set X
     *
     * @param string $x
     *
     * @return BoardState
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get X
     *
     * @return string
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set Y
     *
     * @param string $y
     *
     * @return BoardState
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get Y
     *
     * @return string
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set Z
     *
     * @param string $z
     *
     * @return BoardState
     */
    public function setZ($z)
    {
        $this->z = $z;

        return $this;
    }

    /**
     * Get Z
     *
     * @return string
     */
    public function getZ()
    {
        return $this->z;
    }
}

