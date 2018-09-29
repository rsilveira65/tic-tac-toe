<?php

namespace Tests\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    /** @var Client */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testNewGame()
    {
        $this->client->request('POST', '/api/game/new');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('gameId', $data);
        $this->assertArrayHasKey('board', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('type', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, is_int($data['gameId']));

        $this->assertEquals('Board created/updated successfully!', $data['message']);
        $this->assertEquals('success', $data['type']);
    }

    public function testPlayGame()
    {
        $response = $this->client->request(
            'POST',
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

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('gameId', $data);
        $this->assertArrayHasKey('board', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('type', $data);
        $this->assertArrayHasKey('status', $data);

        $this->assertEquals('X', $data['board'][0][2]);

        $this->assertEquals(true, is_int($data['gameId']));

        $this->assertEquals('Board created/updated successfully!', $data['message']);
        $this->assertEquals('success', $data['type']);
    }
}
