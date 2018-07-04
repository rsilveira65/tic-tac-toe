<?php
/**
 * Created by PhpStorm.
 * User: rsilveira
 * Date: 03/07/18
 * Time: 18:01
 */

namespace ApiBundle\Service\Serializer\Board;


use ApiBundle\Entity\Board;
use ApiBundle\Entity\BoardState;
use ApiBundle\Entity\Game;

class BoardSerializerService
{
    /**
     * @param Game $game
     * @return Game
     */
    public function serialize(Game $game)
    {
        $normalizedBoardResponse = [
            'board' => [],
            'message' => 'Board created/updated successfully!',
            'type' => 'success',
            'status' => $game->getStatus() ? 'Ongoing' : 'Completed'
        ];

        /** @var Board $board */
        $board = $game->getBoard();

        /** @var BoardState $boardState */
        foreach ($board->getBoardStates() as $boardState) {
            $normalizedBoardResponse['board'][] = [$boardState->getX0(), $boardState->getX1(), $boardState->getX2()];
        }

        return $normalizedBoardResponse;
    }
}