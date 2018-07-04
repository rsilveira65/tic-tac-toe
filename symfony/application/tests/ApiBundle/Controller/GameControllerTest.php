<?php

namespace Tests\ApiBundle\Controller;

use Symfony\Component\Routing;

class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \GuzzleHttp\Client $client */
    private $client;

    public function setUp()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => 'http://nginx/']);
    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testNewGame()
    {
        $response = $this->client->post('/api/game/new');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

//        $this->assertArrayHasKey('gameId', $data);
//        $this->assertArrayHasKey('board', $data);
//        $this->assertArrayHasKey('message', $data);
//        $this->assertArrayHasKey('type', $data);
//        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, is_int($data['gameId']));

        $this->assertEquals('Board created/updated successfully!', $data['message']);
        $this->assertEquals('success', $data['type']);
    }

    public function testPlayGame()
    {
        $response = $this->client->post(
            sprintf(
                '/api/game/%s/play', 1
            ),
            [
                'json' => [
                    'gameId' => 1,
                    'move'   => [0, 2, 'X']
                ]
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

//        $this->assertArrayHasKey('gameId', $data);
//        $this->assertArrayHasKey('board', $data);
//        $this->assertArrayHasKey('message', $data);
//        $this->assertArrayHasKey('type', $data);
//        $this->assertArrayHasKey('status', $data);

        $this->assertEquals('X', $data['board'][0][2]);

        $this->assertEquals(true, is_int($data['gameId']));

        $this->assertEquals('Board created/updated successfully!', $data['message']);
        $this->assertEquals('success', $data['type']);
    }
}
