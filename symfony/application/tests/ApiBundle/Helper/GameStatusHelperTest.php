<?php
namespace Tests\ApiBundle\Helper;

use ApiBundle\Helper\GameStatusHelper;
use Symfony\Component\Routing;

class GameStatusHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testGameStatusConstants()
    {
        $this->assertEquals(
            0,
            GameStatusHelper::ONGOING,
            'const ONGOING must be 0.'
        );

        $this->assertEquals(
            1,
            GameStatusHelper::PLAYER_WON,
            'const PLAYER_WON must be 1.'
        );

        $this->assertEquals(
            3,
            GameStatusHelper::DRAW,
            'const DRAW must be 3.'
        );

        $this->assertEquals(
            2,
            GameStatusHelper::BOT_WON,
            'const DRAW must be 2.'
        );
    }
}