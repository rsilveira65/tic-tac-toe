<?php
/**
 * Created by PhpStorm.
 * User: rsilveira
 * Date: 03/07/18
 * Time: 18:03
 */

namespace ApiBundle\Service\Game;


use Symfony\Component\HttpFoundation\Request;

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

    public function getBoardParametersFromRequest(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

}