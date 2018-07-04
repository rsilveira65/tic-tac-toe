<?php
/**
 * Created by PhpStorm.
 * User: rsilveira
 * Date: 03/07/18
 * Time: 17:02
 */

namespace ApiBundle\Controller;

use ApiBundle\Entity\Board;
use ApiBundle\Entity\Game;
use ApiBundle\Service\Game\GamePlayService;
use ApiBundle\Service\Game\GameRequestService;
use ApiBundle\Service\Game\GameService;
use ApiBundle\Service\Serializer\Board\BoardSerializerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GameController
 * @Route("/game")
 *
 * @author Rafael Silveira <rsilveiracc@gmail.com>
 * @package ApiBundle\Controller
 */
class GameController extends AbstractController
{
    /**
     * @Route("/new", name="api_game_new")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function newGameAction()
    {
        try {
            /** @var GameService $gameService */
            $gameService = $this->get('api.game_service');
            /** @var Game $game */
            $game = $gameService->createGame();

            /** @var BoardSerializerService $boardSerializerService */
            $boardSerializerService = $this->get('api.board_serializer_service');

            return $this->createResponse($boardSerializerService->serialize($game), Response::HTTP_OK);

        } catch (\Exception $ex) {
            return $this->createResponse($ex, $ex->getCode());
        }
    }

    /**
     * @Route("/{game}/play", name="api_game_play")
     * @Method("POST")
     * @param Game $game
     * @param Request $request
     * @return JsonResponse
     */
    public function playGameAction(Request $request, Game $game)
    {
        try {

            /** @var GameRequestService $gameRequestService */
            $gameRequestService = $this->get('api.game_request_service');

            /** @var Board $board */
            $parameters = $gameRequestService->getBoardParametersFromRequest($request);

            /** @var GameService $gameService */
            $gameService = $this->get('api.game_service');
            $gameService->setGame($game);

            /** @var Game $game */
            $game = $gameService->updateGame($parameters);

            /** @var GamePlayService $gamePlayService */
            $gamePlayService = $this->get('api.game_play_service');

            $game = $gamePlayService->makeMove($game);

            /** @var BoardSerializerService $boardSerializerService */
            $boardSerializerService = $this->get('api.board_serializer_service');

            return $this->createResponse($boardSerializerService->serialize($game), Response::HTTP_OK);

        } catch (\Exception $ex) {
            return $this->createResponse($ex, $ex->getCode());
        }
    }

}