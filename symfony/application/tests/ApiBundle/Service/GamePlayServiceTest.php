<?php

namespace Tests\ApiBundle\Controller;

use ApiBundle\Service\Game\GamePlayService;
use Symfony\Component\Routing;

class GamePlayServiceTest extends \PHPUnit_Framework_TestCase
{
    private $gamePlayService;

    public function setUp()
    {
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->gamePlayService = new GamePlayService($em);
    }
}