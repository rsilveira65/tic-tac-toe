<?php

namespace Tests\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;


class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testNewGame()
    {
        $test = 'test';
        $this->assertEquals('test', $test);
    }
}
