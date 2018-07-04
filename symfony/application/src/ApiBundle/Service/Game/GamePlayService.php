<?php

namespace ApiBundle\Service\Game;

use ApiBundle\Entity\Board;
use ApiBundle\Entity\BoardState;
use ApiBundle\Entity\Game;
use ApiBundle\Helper\GameMoveIndexHelper;
use ApiBundle\Helper\GameStatusHelper;
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
        $game->setStatus(GameStatusHelper::COMPLETED);

        if (!$this->isGameCompleted($game)) {
            $emptyBoardStateIndexes = $this->getEmptyBoardStateIndexesByGame($game);

            //last movement?
            count($emptyBoardStateIndexes) == 1 ?
                $game->setStatus(GameStatusHelper::COMPLETED) :
                $game->setStatus(GameStatusHelper::ONGOING);

            //Bot chooses a random boardStateIndex.
            $emptyRandomlyBoardStateIndex = $emptyBoardStateIndexes[array_rand($emptyBoardStateIndexes)];

            $boardStates = $game->getBoard()->getBoardStates();

            $setter = "setX{$emptyRandomlyBoardStateIndex[GameMoveIndexHelper::X]}";
            $boardState = $boardStates[$emptyRandomlyBoardStateIndex[GameMoveIndexHelper::Y]];

            $boardState->{$setter}($emptyRandomlyBoardStateIndex[GameMoveIndexHelper::PLAYER]);

            $this->entityManager->persist($boardState);

        }

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $game;
    }

    /**
     * TODO add completed game logic
     * @param Game $game
     * @return bool
     */
    private function isGameCompleted(Game $game)
    {
        $boardStates = $game->getBoard()->getBoardStates();
        //Check rows.
        /** @var BoardState $boardState */
        foreach ($boardStates as $boardState) {
            if ($this->checkRow($boardState->getX0(), $boardState->getX1(), $boardState->getX2())) {
                return true;
            }
        }

        //Check columns.
        $result[] = $this->checkRow($boardStates[0]->getX0(), $boardStates[1]->getX0(), $boardStates[2]->getX0());
        $result[] = $this->checkRow($boardStates[0]->getX1(), $boardStates[1]->getX1(), $boardStates[2]->getX1());
        $result[] = $this->checkRow($boardStates[0]->getX2(), $boardStates[1]->getX2(), $boardStates[2]->getX2());

        //Check diagonals.
        $result[] = $this->checkRow($boardStates[0]->getX0(), $boardStates[1]->getX1(), $boardStates[2]->getX2());
        $result[] = $this->checkRow($boardStates[0]->getX2(), $boardStates[1]->getX1(), $boardStates[2]->getX0());

        return in_array(true, $result) ? true : false;
    }

    /**
     * @param $X0
     * @param $X1
     * @param $X2
     * @return bool
     */
    private function checkRow($X0, $X1, $X2)
    {
        return ($X0 == $X1) and ($X0 == $X2)  ? true : false;
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