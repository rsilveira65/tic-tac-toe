<?php

namespace ApiBundle\Service\Game;

use ApiBundle\Entity\Board;
use ApiBundle\Entity\BoardState;
use ApiBundle\Entity\Game;
use ApiBundle\Helper\GameMoveIndexHelper;
use ApiBundle\Helper\GameStatusHelper;
use Doctrine\ORM\EntityManager;

/**
 * Class GameService
 * @author Rafael Silveira <rsilveiracc@gmail.com>
 * @package ApiBundle\Service\Game
 */
class GameService
{
    /** @var  Game $game */
    private $game;

    /** @var  Board $board */
    private $board;

    const NUMBER_OF_BOARD_STATES = 3;

    /**
     * GamePlayService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Game $game
     * @return Game
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Game
     */
    public function createGame()
    {
        $this->game = new Game();
        $this->game
            ->setBoard($this->createBoard())
            ->setStatus(GameStatusHelper::ONGOING)
            ->setCreated($this->getEuropeDateTime())
            ->setModified($this->getEuropeDateTime());

        $this->entityManager->persist($this->game);
        $this->entityManager->flush();

        return $this->game;
    }

    /**
     * @return Board
     */
    private function createBoard()
    {
        $this->board = new Board();
        $this->board->setGame($this->game);

        $this->createStates();

        return $this->board;
    }


    /**
     * @param $parameters
     * @return Game
     */
    public function updateGame($parameters)
    {
        $this->board = $this->game->getBoard();

        $this->updateStateByMovement($parameters);

        $this->entityManager->flush();

        return $this->game;
    }

    private function createStates()
    {
        for ($state = 1; $state <= self::NUMBER_OF_BOARD_STATES; $state++) {
            /** @var BoardState $boardState */
            $boardState = new BoardState();
            $boardState
                ->setBoard($this->board)
                ->setCreated($this->getEuropeDateTime())
                ->setModified($this->getEuropeDateTime())
                ->setX0(' ')
                ->setX1(' ')
                ->setX2(' ');

            $this->board->addBoardState($boardState);
        }
    }

    /**
     * @param $parameters
     */
    private function updateStateByMovement($parameters)
    {
        $move = $parameters['move'];
        $gameStates = $this->board->getBoardStates();
        $setter = "setX{$move[GameMoveIndexHelper::X]}";
        $gameState = $gameStates[$move[GameMoveIndexHelper::Y]];

        $gameState->{$setter}($move[GameMoveIndexHelper::PLAYER]);

        $this->entityManager->persist($gameState);
        $this->entityManager->flush();
    }

    /**
     * @param string $time
     * @return \Datetime
     */
    private function getEuropeDateTime($time = 'now')
    {
        return new \Datetime($time, new \DateTimeZone('Europe/Berlin'));
    }

}