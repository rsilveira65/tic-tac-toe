<?php

namespace Tests\ApiBundle\Service\Controller;

use ApiBundle\Service\Game\GameRequestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;

class GameRequestServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var  GameRequestService */
    private $gameRequestService;

    public function setUp()
    {
        $this->gameRequestService = new GameRequestService();
    }

    public function testGetBoardParametersFromRequest()
    {
        $request = $this
            ->getMockBuilder(Request::class)
            ->getMock();

        //set the return value
        $request
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('{"gameId": 3, "playerId": 4, "board": [[" "," "," "],[" "," "," "],[" "," "," "]],"move": [0, 2, "X"]}'));


        $parameters = $this->gameRequestService->getBoardParametersFromRequest($request);

        $this->assertArrayHasKey('gameId', $parameters);
        $this->assertArrayHasKey('playerId', $parameters);
        $this->assertArrayHasKey('board', $parameters);
        $this->assertArrayHasKey('move', $parameters);

        $this->assertEquals(true, is_int($parameters['gameId']));
        $this->assertEquals(true, is_int($parameters['playerId']));
    }
}