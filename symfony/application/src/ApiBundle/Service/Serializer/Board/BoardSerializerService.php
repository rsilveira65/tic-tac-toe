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
use ApiBundle\Helper\GameStatusHelper;

class BoardSerializerService
{
    /**
     * @param Game $game
     * @return Game
     */
    public function serialize(Game $game)
    {
        $normalizedBoardResponse = [
            'gameId' => $game->getId(),
            'board' => [],
            'message' => 'Board created/updated successfully!',
            'type' => 'success',
            'action' => $this->getActionByStatus($game->getStatus()),
            'status' => $game->getStatus() == GameStatusHelper::ONGOING ? 'Ongoing' : 'Completed'
        ];

        /** @var Board $board */
        $board = $game->getBoard();

        /** @var BoardState $boardState */
        foreach ($board->getBoardStates() as $boardState) {
            $normalizedBoardResponse['board'][] = [$boardState->getX0(), $boardState->getX1(), $boardState->getX2()];
        }

        return $normalizedBoardResponse;
    }

    /**
     * @param $status
     * @return string
     */
    private function getActionByStatus($status)
    {
        $action = 'PlayNextTime';

        if ($status == GameStatusHelper::BOT_WON) {
            $action = 'BotWon';
        }

        if ($status == GameStatusHelper::PLAYER_WON) {
            $action = 'PlayerWon';
        }

        if ($status == GameStatusHelper::DRAW) {
            $action = 'Draw';
        }

        return $action;
    }
}