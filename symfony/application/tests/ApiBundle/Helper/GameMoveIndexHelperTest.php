<?php
namespace Tests\ApiBundle\Helper;

use ApiBundle\Helper\GameMoveIndexHelper;
use Symfony\Component\Routing;

class GameMoveIndexHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testGameMoveIndexConstants()
    {
        $this->assertEquals(
            0,
            GameMoveIndexHelper::Y,
            'const Y must be 0.'
        );

        $this->assertEquals(
            1,
            GameMoveIndexHelper::X,
            'const X must be 1.'
        );

        $this->assertEquals(
            2,
            GameMoveIndexHelper::PLAYER,
            'const PLAYER must be 2.'
        );
    }
}