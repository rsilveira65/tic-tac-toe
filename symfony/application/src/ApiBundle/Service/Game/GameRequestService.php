<?php

namespace ApiBundle\Service\Game;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameRequestService
 * @author Rafael Silveira <rsilveiracc@gmail.com>
 * @package ApiBundle\Service\Game
 */
class GameRequestService
{
    private $request;

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getBoardParametersFromRequest(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

}