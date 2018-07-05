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

    const PLAYER = 'X';

    const BOT = 'O';

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
        //Player won
        $game->setStatus(GameStatusHelper::PLAYER_WON);

        if (!$this->isGameCompletedForPlayer($game, self::PLAYER)) {
            $game->setStatus(GameStatusHelper::ONGOING);

            $this->playGameAsBotPlayer($game);
        }

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $game;
    }

    /**
     * @param Game $game
     */
    private function playGameAsBotPlayer(Game $game)
    {
        $emptyBoardStateIndexes = $this->getEmptyBoardStateIndexesByGame($game);

        //Bot chooses a random boardStateIndex.
        $emptyRandomlyBoardStateIndex = $emptyBoardStateIndexes[array_rand($emptyBoardStateIndexes)];

        $boardStates = $game->getBoard()->getBoardStates();

        $setter = "setX{$emptyRandomlyBoardStateIndex[GameMoveIndexHelper::X]}";
        $boardState = $boardStates[$emptyRandomlyBoardStateIndex[GameMoveIndexHelper::Y]];

        $boardState->{$setter}($emptyRandomlyBoardStateIndex[GameMoveIndexHelper::PLAYER]);

        $game->setMove(
            [
                $emptyRandomlyBoardStateIndex[GameMoveIndexHelper::Y],
                $emptyRandomlyBoardStateIndex[GameMoveIndexHelper::X],
                $emptyRandomlyBoardStateIndex[GameMoveIndexHelper::PLAYER]
            ]
        );

        $this->entityManager->persist($boardState);

        $botWonGame = $this->isGameCompletedForPlayer($game, self::BOT);

        if ($botWonGame) {
            $game->setStatus(GameStatusHelper::BOT_WON);
        }

        //Latest move.
        if (!$botWonGame and count($emptyBoardStateIndexes) == 1) {
            $game->setStatus(GameStatusHelper::DRAW);
        }
    }

    /**
     * @param Game $game
     * @param string $player
     * @return bool
     */
    private function isGameCompletedForPlayer(Game $game, $player)
    {
        $boardStates = $game->getBoard()->getBoardStates();
        //Check rows.
        /** @var BoardState $boardState */
        foreach ($boardStates as $boardState) {
            if ($this->checkRow([$boardState->getX0(), $boardState->getX1(), $boardState->getX2()], $player)) {
                return true;
            }
        }

        //Check columns.
        $result[] = $this->checkRow([$boardStates[0]->getX0(), $boardStates[1]->getX0(), $boardStates[2]->getX0()], $player);
        $result[] = $this->checkRow([$boardStates[0]->getX1(), $boardStates[1]->getX1(), $boardStates[2]->getX1()], $player);
        $result[] = $this->checkRow([$boardStates[0]->getX2(), $boardStates[1]->getX2(), $boardStates[2]->getX2()], $player);

        //Check diagonals.
        $result[] = $this->checkRow([$boardStates[0]->getX0(), $boardStates[1]->getX1(), $boardStates[2]->getX2()], $player);
        $result[] = $this->checkRow([$boardStates[0]->getX2(), $boardStates[1]->getX1(), $boardStates[2]->getX0()], $player);

        return in_array(true, $result) ? true : false;
    }

    /**
     * @param array $values
     * @param string $player
     * @return bool
     */
    private function checkRow($values, $player)
    {
        foreach ($values as $value) {
            if (ctype_space($value)) return false;
        }

        return ($values[0] == $player and $values[1] == $player) and ($values[0] == $player and $values[2] == $player) ? true : false;
    }

    /**
     * @param Game $game
     * @return array
     */
    private function getEmptyBoardStateIndexesByGame(Game $game)
    {
        /** @var Board $board */
        $board = $game->getBoard();

        $row = 0;
        $freeIndexes = [];
        /** @var BoardState $boardState */
        foreach ($board->getBoardStates() as $boardState) {
            if (!trim($boardState->getX0())) {
                $freeIndexes[] = [$row, 0, 'O'];
            }

            if (!trim($boardState->getX1())) {
                $freeIndexes[] = [$row, 1, 'O'];
            }

            if (!trim($boardState->getX2())) {
                $freeIndexes[] = [$row, 2, 'O'];
            }

            $row++;
        }

        return $freeIndexes;
    }

}