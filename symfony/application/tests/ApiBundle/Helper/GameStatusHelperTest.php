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
            GameStatusHelper::COMPLETED,
            'const COMPLETED must be 1.'
        );
    }
}