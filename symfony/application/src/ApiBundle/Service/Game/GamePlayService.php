<?php

namespace ApiBundle\Service\Game;

use ApiBundle\Entity\Board;
use ApiBundle\Entity\BoardState;
use ApiBundle\Entity\Game;
use Doctrine\ORM\EntityManager;

/**
 * Class GamePlayService
 * @author Rafael Silveira <rsilveiracc@gmail.com>
 * @package ApiBundle\Service\Game
 */
class GamePlayService implements GamePlayServiceInterface
{
    /** @var  EntityManager $entityManager */
    private $entityManager;

    const Y = 0;
    const X = 1;
    const PLAYER = 2;

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
    public function makeMove(Game $game)
    {
        $game->setStatus(2);

        if (!$this->isGameCompleted($game)) {
            $emptyBoardStateIndexes = $this->getEmptyBoardStateIndexesByGame($game);

            $emptyBoardStateIndex = $emptyBoardStateIndexes[array_rand($emptyBoardStateIndexes)];

            $boardStates = $game->getBoard()->getBoardStates();

            $setter = "setX{$emptyBoardStateIndex[self::X]}";
            $boardState = $boardStates[$emptyBoardStateIndex[self::Y]];

            $boardState->{$setter}($emptyBoardStateIndex[self::PLAYER]);

            $this->entityManager->persist($boardState);
        }

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $game;
    }

    /**
     * TODO add completed game test
     * @param Game $game
     * @return bool
     */
    private function isGameCompleted(Game $game)
    {
        return false;
    }

    /**
     * @param Game $game
     * @return array
     */
    private function getEmptyBoardStateIndexesByGame(Game $game)
    {
        /** @var Board $board */
        $board = $game->getBoard();

        $coordinateY = 0;
        $freeIndexes = [];
        /** @var BoardState $boardState */
        foreach ($board->getBoardStates() as $boardState) {
            if (!trim($boardState->getX0())) {
                $freeIndexes[] = [$coordinateY, 0, 'O'];
            }

            if (!trim($boardState->getX1())) {
                $freeIndexes[] = [$coordinateY, 1, 'O'];
            }

            if (!trim($boardState->getX2())) {
                $freeIndexes[] = [$coordinateY, 2, 'O'];
            }

            $coordinateY++;
        }

        return $freeIndexes;
    }


}